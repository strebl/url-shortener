
const $ = require('jquery')
global.jQuery = $

const Tether = require('tether')
global.Tether = Tether

require('bootstrap')

import Clipboard from 'clipboard';

export default class {
    constructor() {
        const clipboard = new Clipboard('[data-toggle="tooltip"]')

        clipboard.on('success', (e) => {
            this.showTooltip(e.trigger, 'Copied!')
        });

        clipboard.on('error', (e) => {
            this.showTooltip(e.trigger, 'Press ⌘+C to copy')
        })
    }

    showTooltip(element, text) {
        $(element)
            .attr('title', text)
            .tooltip('dispose')
            .tooltip('show')
    }
}