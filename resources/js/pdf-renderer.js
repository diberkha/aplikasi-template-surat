const puppeteer = require("puppeteer");
const fs = require("fs");
const path = require("path");
const { pathToFileURL } = require('url');

(async () => {
    const args = process.argv.slice(2);
    if (args.length < 2) {
        console.error(
            "Usage: node pdf-renderer.js <input_html_file> <output_pdf_file> [width] [height] [marginTop] [marginBottom] [marginLeft] [marginRight]",
        );
        process.exit(1);
    }

    const inputPath = args[0];
    const outputPath = args[1];
    const width = args[2] || "215.9mm";
    const height = args[3] || "330.2mm";
    const marginTop = args[4] || "13mm";
    const marginBottom = args[5] || "12mm";
    const marginLeft = args[6] || "18mm";
    const marginRight = args[7] || "18mm";

    const toFileUrl = (filePath) => {
        return pathToFileURL(filePath).href;
    };

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

        await page.setViewport({
            width: 794,
            height: 1123
        });

        const absoluteInputPath = path.resolve(inputPath);

        if (!fs.existsSync(absoluteInputPath)) {
            console.error("Input HTML not found:", absoluteInputPath);
            process.exit(2);
        }

        const fileUrl = toFileUrl(absoluteInputPath);

        await page.goto(fileUrl, {
            waitUntil: "networkidle0",
        });

        await page.pdf({
            path: outputPath,
            width: width,
            height: height,
            printBackground: true,
            margin: {
                top: marginTop,
                bottom: marginBottom,
                left: marginLeft,
                right: marginRight
            }
        });

        console.log("PDF generated successfully: " + outputPath);
    } catch (error) {
        console.error("Error generating PDF:", error && error.stack ? error.stack : error);
        try {
            if (typeof page !== 'undefined') {
                const debugPath = outputPath + '.error.png';
                await page.screenshot({ path: debugPath, fullPage: true });
                console.error('Saved debug screenshot to', debugPath);
            }
        } catch (sErr) {
            // ignore screenshot errors
        }
        process.exit(1);
    } finally {
        await browser.close();
    }
})();
