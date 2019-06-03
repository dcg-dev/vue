(function () {
    this.StringHelper = function (string) {
        this.string = string;
        
        this.explode = function(separator, limit) {
            return this.string.split(separator, limit);
        };
        
        this.truncate = function(stringLength) {
            //clear text from html chars
            var dom = document.createElement("DIV");
            dom.innerHTML = this.string;
            var plainText = (dom.textContent || dom.innerText);

            //create and set a stringLength char string to the hidden form field
            return plainText.length > stringLength ? plainText.substr(0, stringLength) + "..." : plainText;
        };
    }
}());
