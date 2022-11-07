const puppeteer = require("puppeteer");

const scrape = async (web_site) => {
    const browser = await puppeteer.launch();
    const page = await browser.newPage();
    await page.goto(web_site);
    try{
    let element = await page.$eval('link[rel="shortcut icon"]', el => el.getAttribute('href'));

    console.log(element);
    browser.close();
    } catch(error) {
        console.log("Shortcut Icon Bulunamadı");
        browser.close();
    }
}

// Çalışıyor sistem

export default scrape;
