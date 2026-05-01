/**
 * Footer Tests - Validate footer structure and styling across viewports
 *
 * Run with: npx playwright test tests/footer.spec.js
 */

const { test, expect } = require('@playwright/test');
const { getStyle, getStyles, VIEWPORTS } = require('../vendor/seilerinstrument/wp-test-utils/playwright');

// Expected values
const EXPECTED = {
	navLink: {
		fontWeight: '600',
		fontSizeMin: 12,
		fontSizeMax: 14,
	},
	copyright: {
		// Inline style sets margin-top:1.5rem (= 24px at default 16px root)
		marginTop: '24px',
	},
};

test.describe('Footer Desktop', () => {
	test.beforeEach(async ({ page }) => {
		await page.setViewportSize(VIEWPORTS.desktop);
		await page.goto('/', { waitUntil: 'domcontentloaded', timeout: 60000 });
	});

	test('footer exists and is visible', async ({ page }) => {
		// Two elements carry .site-footer (the <footer> template part and the inner div);
		// target the semantic <footer> element to avoid strict-mode violation.
		const footer = page.locator('footer.site-footer');
		await expect(footer).toBeVisible();
	});

	test('since-group has vertical writing-mode on desktop', async ({ page }) => {
		const sinceGroup = page.locator('.footer-since-group');
		await expect(sinceGroup).toBeVisible();

		const writingMode = await getStyle(page.locator('.footer-since-text'), 'writingMode');
		expect(writingMode).toBe('vertical-rl');
	});

	test('nav links have correct font-weight and text-decoration', async ({ page }) => {
		const firstLink = page.locator('.footer-nav-links a').first();

		const fontWeight = await getStyle(firstLink, 'fontWeight');
		expect(fontWeight).toBe(EXPECTED.navLink.fontWeight);

		const textDecoration = await getStyle(firstLink, 'textDecoration');
		expect(textDecoration).toContain('none');
	});

	test('nav link font-size falls within clamp range (12–14px)', async ({ page }) => {
		const firstLink = page.locator('.footer-nav-links a').first();

		const fontSize = await getStyle(firstLink, 'fontSize');
		const px = parseFloat(fontSize);
		expect(px).toBeGreaterThanOrEqual(EXPECTED.navLink.fontSizeMin);
		expect(px).toBeLessThanOrEqual(EXPECTED.navLink.fontSizeMax);
	});

	test('copyright margin-top matches inline style (1.5rem)', async ({ page }) => {
		// NOTE: CSS only sets text-align:left — it does NOT reset margin-top.
		// The inline style (margin-top:30px) is the authoritative value.
		const marginTop = await getStyle(page.locator('.footer-copyright'), 'marginTop');
		expect(marginTop).toBe(EXPECTED.copyright.marginTop);
	});

	test('footer logo container has no margin', async ({ page }) => {
		const logo = page.locator('.footer-logo.wp-block-site-logo');

		const margins = await getStyles(logo, 'marginTop', 'marginRight', 'marginBottom', 'marginLeft');

		expect(margins.marginTop).toBe('0px');
		expect(margins.marginRight).toBe('0px');
		expect(margins.marginBottom).toBe('0px');
		expect(margins.marginLeft).toBe('0px');
	});

	test('address separator is not block on desktop', async ({ page }) => {
		const sep = page.locator('.footer-address span.txt-sep').first();

		const display = await getStyle(sep, 'display');
		// Desktop: CSS does not apply the 450px block rule — should be inline or inline-block
		expect(display).not.toBe('block');
	});
});

test.describe('Footer Mobile', () => {
	test.beforeEach(async ({ page }) => {
		await page.setViewportSize(VIEWPORTS.mobile);
		await page.goto('/', { waitUntil: 'domcontentloaded', timeout: 60000 });
	});

	test('since-group is hidden on mobile', async ({ page }) => {
		const sinceGroup = page.locator('.footer-since-group');

		const display = await getStyle(sinceGroup, 'display');
		expect(display).toBe('none');
	});

	test('top-row stacks vertically on mobile', async ({ page }) => {
		const topRow = page.locator('.footer-top-row');

		const flexDirection = await getStyle(topRow, 'flexDirection');
		expect(flexDirection).toBe('column');
	});

	test('copyright text aligns center on mobile', async ({ page }) => {
		const copyright = page.locator('.footer-copyright');

		const textAlign = await getStyle(copyright, 'textAlign');
		expect(textAlign).toBe('center');
	});

	test('address separator becomes block on narrow viewport', async ({ page }) => {
		const sep = page.locator('.footer-address span.txt-sep').first();

		const display = await getStyle(sep, 'display');
		expect(display).toBe('block');
	});
});
