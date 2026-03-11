const puppeteer = require("puppeteer");
const fs = require("fs");
const path = require("path");
const { pathToFileURL } = require('url');

let logFilePath = null;
function writeLog(msg) {
    const line = new Date().toISOString() + ' ' + msg + '\n';
    if (logFilePath) {
        try { fs.appendFileSync(logFilePath, line); } catch(e) { }
    }
    console.error(line.trim());
}

(async () => {
    const args = process.argv.slice(2);

    let inputPath, outputPath, width, height, marginTop, marginBottom, marginLeft, marginRight, chromePath;

    writeLog('pdf-renderer.js started, args: ' + JSON.stringify(args));
    writeLog('cwd: ' + process.cwd());
    writeLog('node version: ' + process.version);

    if (args.length === 1 && args[0].endsWith('.json')) {
        try {
            const configRaw = fs.readFileSync(args[0], 'utf8');
            writeLog('Config file contents: ' + configRaw);
            const config = JSON.parse(configRaw);
            inputPath = config.inputPath;
            outputPath = config.outputPath;
            width = config.width || "215.9mm";
            height = config.height || "330.2mm";
            marginTop = config.marginTop || "13mm";
            marginBottom = config.marginBottom || "12mm";
            marginLeft = config.marginLeft || "18mm";
            marginRight = config.marginRight || "18mm";
            chromePath = config.chromePath || process.env.CHROME_PATH || undefined;
            logFilePath = config.logFile || null;
            writeLog('Config parsed OK. chromePath=' + (chromePath || '(auto)'));
        } catch (e) {
            writeLog("Failed to read config JSON: " + e.message);
            console.error("Failed to read config JSON:", e.message);
            process.exit(1);
        }
    } else if (args.length >= 2) {
        inputPath = args[0];
        outputPath = args[1];
        width = args[2] || "215.9mm";
        height = args[3] || "330.2mm";
        marginTop = args[4] || "13mm";
        marginBottom = args[5] || "12mm";
        marginLeft = args[6] || "18mm";
        marginRight = args[7] || "18mm";
        chromePath = args[8] || process.env.CHROME_PATH || undefined;
    } else {
        console.error(
            "Usage: node pdf-renderer.js <config.json>\n" +
            "   or: node pdf-renderer.js <input_html_file> <output_pdf_file> [width] [height] [marginTop] [marginBottom] [marginLeft] [marginRight] [chromePath]",
        );
        process.exit(1);
    }

    if (!inputPath || !outputPath) {
        writeLog("inputPath and outputPath are required");
        console.error("inputPath and outputPath are required");
        process.exit(1);
    }

    const toFileUrl = (filePath) => {
        return pathToFileURL(filePath).href;
    };

    writeLog('Launching browser with chromePath=' + (chromePath || '(auto-detect)'));

    const browser = await puppeteer.launch({
        headless: "new",
        executablePath: chromePath,
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
        writeLog('Browser launched OK');
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
        writeLog("PDF generated successfully: " + outputPath);
    } catch (error) {
        writeLog("Error generating PDF: " + (error && error.stack ? error.stack : error));
        console.error("Error generating PDF:", error && error.stack ? error.stack : error);
        try {
            if (typeof page !== 'undefined') {
                const debugPath = outputPath + '.error.png';
                await page.screenshot({ path: debugPath, fullPage: true });
                console.error('Saved debug screenshot to', debugPath);
            }
        } catch (sErr) {
        }
        process.exit(1);
    } finally {
        await browser.close();
    }
})();
