const $ = require('jquery')
global.jQuery = $

const Tether = require('tether')
global.Tether = Tether

require('bootstrap')

export default class Tooltips {

    constructor() {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    }
}