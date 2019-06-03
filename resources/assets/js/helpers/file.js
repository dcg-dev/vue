(function () {
    this.FileSize = function (bytes) {
        this.bytes = bytes;
        
        this.humanize = function(decimals) {
            bytes = this.bytes;
            if(bytes == 0) return '0 Bytes';
            var k = 1000,
                dm = decimals || 2,
                sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
                i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }
    }
}());
(function () {
    this.File = function () {
        
        this.size = function(size) {
            return new FileSize(size);
        }
    }
}());

window.file = function () {
    return new File();
};