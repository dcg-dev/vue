(function () {
    this.Social = function () {
        
    }
}());

(function () {
    this.Facebook = function () {
        this.share = function(url) {
            if(!url) {
                url = location.href;
            }
            window.open('https://www.facebook.com/sharer/sharer.php?u='+url,'facebook-share-dialog',"width=626,height=436")
        }
    }
    Social.prototype.facebook = function () {
        return new Facebook();
    }
}());

(function () {
    this.Google = function () {
        this.share = function(url) {
            if(!url) {
                url = location.href;
            }
            window.open('https://plus.google.com/share?url='+url,'google-share-dialog',"width=626,height=436")
        }
    }
    Social.prototype.google = function () {
        return new Google();
    }
}());

(function () {
    this.LinkedIn = function () {
        this.share = function(url) {
            if(!url) {
                url = location.href;
            }
            window.open('https://www.linkedin.com/cws/share?url='+url,'google-share-dialog',"width=626,height=436")
        }
    }
    Social.prototype.linkedin = function () {
        return new LinkedIn();
    }
}());

(function () {
    this.Twitter = function () {
        this.share = function(url, text, hashtags, via, related) {
            if(!url) {
                url = location.href;
            }
            var attributes = {
                'text': text,
                'url': url,
                'hashtags': hashtags,
                'via': via,
                'related': related,
            };
            window.open('https://twitter.com/share?'+queryString.stringify(attributes),'twitter',"width=626,height=436")
        }
    }
    Social.prototype.twitter = function () {
        return new Twitter();
    }
}());

window.social = function () {
    return new Social();
};