/**
 * Search for searchbox
 * Input id should be "search"
 * url - required
 * callback required
 */
class Search {
    constructor(url) {
        this.param = {};
        this.url = url;               
    }

    setParam(param = {}) {
        this.param = param;
    }

    appendParam(param){
        this.param = this.param
            ? Object.assign(this.param, param)
            : param;
    }
}
