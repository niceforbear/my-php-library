// Add trim method to String prototype
String.prototype.trim = String.prototype.trim || function(){
            if(!this)
                return this;
            return this.replace(/^\s+|\s+$/g, "");
    };

// Add getName method to Function prototype
Function.prototype.getName = function(){
    return this.name || this.toString().match(/function\s*([^()*]\(/)))[1];
}
