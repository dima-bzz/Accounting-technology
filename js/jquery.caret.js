// Set carett position easily in jQuery
// Written by and Copyright of Luke Morton, 2011
// Licensed under MIT
(function ($) {
    // Behind the scenes method deals with browser
    // idiosyncrasies and such
    $.carettTo = function (el, index) {
        if (el.createTextRange) {
            var range = el.createTextRange();
            range.move("character", index);
            range.select();
        } else if (el.selectionStart != null) {
            el.focus();
            el.setSelectionRange(index, index);
        }
    };

    // Another behind the scenes that collects the
    // current carett position for an element

    // TODO: Get working with Opera
    $.carettPos = function (el) {
        if ("selection" in document) {
            var range = el.createTextRange();
            try {
                range.setEndPoint("EndToStart", document.selection.createRange());
            } catch (e) {
                // Catch IE failure here, return 0 like
                // other browsers
                return 0;
            }
            return range.text.length;
        } else if (el.selectionStart != null) {
            return el.selectionStart;
        }
    };

    // The following methods are queued under fx for more
    // flexibility when combining with $.fn.delay() and
    // jQuery effects.

    // Set carett to a particular index
    $.fn.carett = function (index, offset) {
        if (typeof(index) === "undefined") {
            return $.carettPos(this.get(0));
        }

        return this.queue(function (next) {
            if (isNaN(index)) {
                var i = $(this).val().indexOf(index);

                if (offset === true) {
                    i += index.length;
                } else if (typeof(offset) !== "undefined") {
                    i += offset;
                }

                $.carettTo(this, i);
            } else {
                $.carettTo(this, index);
            }

            next();
        });
    };

    // Set carett to beginning of an element
    $.fn.carettToStart = function () {
        return this.carett(0);
    };

    // Set carett to the end of an element
    $.fn.carettToEnd = function () {
        return this.queue(function (next) {
            $.carettTo(this, $(this).val().length);
            next();
        });
    };
}(jQuery));