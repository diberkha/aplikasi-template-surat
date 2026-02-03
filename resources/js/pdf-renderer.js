const puppeteer = require("puppeteer");
const fs = require("fs");
const path = require("path");

(async () => {
    const args = process.argv.slice(2);
    if (args.length < 2) {
        console.error(
            "Usage: node pdf-renderer.js <input_html_file> <output_pdf_file> [width] [height]",
        );
        process.exit(1);
    }

    const inputPath = args[0];
    const outputPath = args[1];
    const width = args[2] || "215.9mm";
    const height = args[3] || "330.2mm";

    const browser = await puppeteer.launch({
        headless: "new",
        executablePath: process.env.CHROME_PATH || undefined,
        args: [
            "--no-sandbox",
            "--disable-setuid-sandbox",
            "--disable-dev-shm-usage",
            "--disable-accelerated-2d-canvas",
            "--disable-gpu",
            "--no-first-run",
            "--no-zygote",
            "--font-render-hinting=none",
        ],
    });

    try {
        const page = await browser.newPage();

        const absoluteInputPath = path.resolve(inputPath);
        const fileUrl = "file://" + absoluteInputPath;

        await page.goto(fileUrl, {
            waitUntil: "networkidle0",
        });

        await page.pdf({
            path: outputPath,
            preferCSSPageSize: true,
            printBackground: true,
        });

        console.log("PDF generated successfully: " + outputPath);
    } catch (error) {
        console.error("Error generating PDF:", error);
        process.exit(1);
    } finally {
        await browser.close();
    }
})();
