import { expect, fixture } from '@open-wc/testing';
/* this test file can be run on command line with npm run test
   or with visual debug via npm run test:visual */

import '../dist/index.js';

describe('CAGov Scrollable Card', function unitTest() {
  this.timeout(9000);
  it('works', async () => {
    const response = await fetch('../template.html');
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    // const startHTML = await response.text();
    // const el = await fixture(`<div>${startHTML}</div>`); 

    // expect(el.querySelector('details').hasAttribute('open')).to.equal(false);

    await expect(el).to.be.accessible(); // Accessibility check

    return true; // Q: Will this short circuit the test until we can describe the component features enough to write test for them
  });
});