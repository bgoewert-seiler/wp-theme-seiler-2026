/**
 * Header Tests - Validate header functionality and styling
 *
 * Run with: npx playwright test tests/header.spec.js
 */

const { test, expect } = require('@playwright/test');
const { getStyle } = require('../vendor/seilerinstrument/wp-test-utils/playwright');

// Expected values
const EXPECTED = {
	header: {
		minHeight: 110,
		maxHeight: 170
	},
	utilityNav: {
		fontSize: '14px',
		fontWeight: '900',
		color: 'rgb(4, 117, 188)', // #0475bc
	},
	cart: {
		fontSize: '14px',
		fontWeight: '900',
	},
	search: {
		iconSize: 18,
	}
};

test.describe('Header Styling', () => {
	test.beforeEach(async ({ page }) => {
		await page.goto('/', { waitUntil: 'domcontentloaded', timeout: 60000 });
	});

	test('utility nav links should have correct styling', async ({ page }) => {
		const firstLink = page.locator('.header-utility-nav a').first();

		// Check font size
		const fontSize = await getStyle(firstLink, 'fontSize');
		expect(fontSize).toBe(EXPECTED.utilityNav.fontSize);

		// Check font weight
		const fontWeight = await getStyle(firstLink, 'fontWeight');
		expect(fontWeight).toBe(EXPECTED.utilityNav.fontWeight);

		// Check color
		const color = await getStyle(firstLink, 'color');
		expect(color).toBe(EXPECTED.utilityNav.color);

		// Check text decoration (should be none)
		const textDecoration = await getStyle(firstLink, 'textDecoration');
		expect(textDecoration).toContain('none');
	});

	test('cart link should be visible with icon', async ({ page }) => {
		const cart = page.locator('.cart-link-nav');

		await expect(cart).toBeVisible();

		// Check if icon exists
		const icon = cart.locator('.dashicons-cart');
		await expect(icon).toBeVisible();

		// Check font weight
		const fontWeight = await getStyle(cart, 'fontWeight');
		expect(fontWeight).toBe(EXPECTED.cart.fontWeight);
	});

	test('search toggle should be visible', async ({ page }) => {
		const searchToggle = page.locator('.header-search-toggle');

		// Check visibility
		await expect(searchToggle).toBeVisible();

		// Check icon exists
		const icon = searchToggle.locator('.dashicons-search');
		await expect(icon).toBeVisible();

		// Check icon size
		const iconSize = await getStyle(icon, 'fontSize');
		expect(parseInt(iconSize)).toBeGreaterThanOrEqual(EXPECTED.search.iconSize);
	});

	test('header height should be reasonable', async ({ page }) => {
		const header = page.getByRole('banner');

		const height = await header.evaluate(el =>
			el.getBoundingClientRect().height
		);

		// Should be between min and max expected height
		expect(height).toBeGreaterThanOrEqual(EXPECTED.header.minHeight);
		expect(height).toBeLessThanOrEqual(EXPECTED.header.maxHeight);
	});

	test('search toggle functionality', async ({ page }) => {
		const searchToggle = page.locator('.header-search-toggle');
		const searchContainer = page.locator('.header-search-container');

		// Initially search container should not be visible
		await expect(searchContainer).not.toBeVisible();

		// Click search button
		await searchToggle.click();

		// Search container should now be visible
		await expect(searchContainer).toBeVisible();

		// Search input should be focused
		const searchInput = page.locator('.header-search-input');
		await expect(searchInput).toBeFocused();
	});

	test('utility nav should have login and cart links', async ({ page }) => {
		const utilityNav = page.locator('.header-utility-nav');

		// Check for login link
		const loginLink = utilityNav.getByText('Login');
		await expect(loginLink).toBeVisible();

		// Check for cart link
		const cartLink = utilityNav.locator('.cart-link-nav');
		await expect(cartLink).toBeVisible();

		// Cart should show count
		const cartText = await cartLink.textContent();
		expect(cartText?.replace(/\s+/g, ' ').trim()).toMatch(/Cart.*\(\d+\)/);
	});
});
