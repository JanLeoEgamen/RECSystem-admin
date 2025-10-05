const puppeteer = require('puppeteer');
const fs = require('fs');
const path = require('path');

async function captureHtmlAsImage(htmlContent, outputPath, options = {}) {
    const {
        width = 1485, // A4 landscape width at 150 DPI (297mm * 5)
        height = 1050, // A4 landscape height at 150 DPI (210mm * 5)
        quality = 100,
        format = 'png',
        deviceScaleFactor = 2
    } = options;

    let browser;
    try {
        console.log('Starting Puppeteer browser...');
        browser = await puppeteer.launch({
            headless: 'new',
            args: [
                '--no-sandbox',
                '--disable-setuid-sandbox',
                '--disable-dev-shm-usage',
                '--disable-gpu',
                '--no-first-run',
                '--no-zygote',
                '--single-process',
                '--disable-web-security',
                '--window-size=1485,1050'
            ]
        });

        console.log('Creating new page...');
        const page = await browser.newPage();
        
        // Set viewport to match certificate dimensions
        await page.setViewport({
            width: width,
            height: height,
            deviceScaleFactor: deviceScaleFactor
        });

        console.log('Setting page content...');
        await page.setContent(htmlContent, {
            waitUntil: ['networkidle0'], // Wait for all network requests to complete
            timeout: 60000
        });

        console.log('Waiting for full rendering...');
        
        // === ADD THIS SECTION ===
        // Wait for specific elements to ensure they're loaded
        await page.waitForSelector('.certificate', { timeout: 30000 });
        await page.waitForSelector('.logo-bottom', { timeout: 30000 });
        await page.waitForSelector('.border-outer', { timeout: 30000 });
        
        // Additional wait for layout to stabilize
        await new Promise(resolve => setTimeout(resolve, 3000));

        // === ADD THIS SECTION ===
        // Force CSS to apply and ensure logo positioning
        await page.evaluate(() => {
            // Force reflow
            document.body.offsetHeight;
            
            // Ensure logo is at bottom
            const logo = document.querySelector('.logo-bottom');
            if (logo) {
                logo.style.bottom = '25mm';
                logo.style.top = 'auto';
                logo.style.right = '25mm';
            }
            
            // Ensure certificate has proper height
            const certificate = document.querySelector('.certificate');
            if (certificate) {
                certificate.style.height = '210mm';
                certificate.style.minHeight = '210mm';
            }
            
            // Ensure certificate content has proper height
            const certificateContent = document.querySelector('.certificate-content');
            if (certificateContent) {
                certificateContent.style.height = '180mm';
                certificateContent.style.minHeight = '180mm';
            }
        });

        // Wait a bit more for the styles to apply
        await new Promise(resolve => setTimeout(resolve, 2000));
        // === END OF ADDED SECTION ===

        console.log('Taking screenshot...');
        
        // Find the certificate element
        const certificateElement = await page.$('.certificate');
        if (!certificateElement) {
            throw new Error('Certificate element not found');
        }
        
        // Get the exact bounding box
        const boundingBox = await certificateElement.boundingBox();
        
        if (!boundingBox) {
            throw new Error('Could not get certificate bounding box');
        }

        console.log(`Certificate bounds: x=${boundingBox.x}, y=${boundingBox.y}, width=${boundingBox.width}, height=${boundingBox.height}`);
        
        // Take screenshot with exact certificate dimensions
        const screenshotOptions = {
            path: outputPath,
            type: format,
            omitBackground: false,
            clip: {
                x: Math.round(boundingBox.x),
                y: Math.round(boundingBox.y),
                width: Math.round(boundingBox.width),
                height: Math.round(boundingBox.height)
            }
        };

        if (format === 'jpeg') {
            screenshotOptions.quality = quality;
        }

        await page.screenshot(screenshotOptions);

        console.log(`Certificate image generated successfully: ${outputPath}`);
        return { success: true, path: outputPath };

    } catch (error) {
        console.error('Error generating certificate image:', error);
        return { success: false, error: error.message };
    } finally {
        if (browser) {
            await browser.close();
        }
    }
}

// Handle command line arguments
if (require.main === module) {
    const args = process.argv.slice(2);
    if (args.length < 2) {
        console.error('Usage: node capture-certificate.js <html-file-path> <output-image-path> [options]');
        process.exit(1);
    }

    const [htmlFilePath, outputImagePath, optionsJson] = args;
    
    try {
        const htmlContent = fs.readFileSync(htmlFilePath, 'utf8');
        
        // Determine format from file extension
        const format = outputImagePath.toLowerCase().endsWith('.jpeg') || outputImagePath.toLowerCase().endsWith('.jpg') ? 'jpeg' : 'png';
        
        const defaultOptions = {
            width: 1485,
            height: 1050,
            quality: 100,
            format: format,
            deviceScaleFactor: 2
        };
        
        const options = optionsJson ? { ...defaultOptions, ...JSON.parse(optionsJson) } : defaultOptions;
        
        captureHtmlAsImage(htmlContent, outputImagePath, options)
            .then(result => {
                if (result.success) {
                    console.log('SUCCESS');
                    process.exit(0);
                } else {
                    console.error('FAILED:', result.error);
                    process.exit(1);
                }
            })
            .catch(error => {
                console.error('FAILED:', error.message);
                process.exit(1);
            });
    } catch (error) {
        console.error('Error reading HTML file:', error.message);
        process.exit(1);
    }
}

module.exports = captureHtmlAsImage;    