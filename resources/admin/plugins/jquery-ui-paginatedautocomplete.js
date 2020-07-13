$.widget("scottsJewels.paginatedAutocomplete", $.ui.autocomplete, {

    options: {
        minLength: 1,
        sourceUrl: '',
        pageSize: 10,
        data: {},
        source: function (request, response) {
            var self = this;
            // loaderAjax(self.element, "input");
            dados = {
                pageSize: self.options.pageSize,
                term: `${request.term}%`,
                pageIndex: self._pageIndex,
            };

            for (var i in self.options.data) {
                dados[i] = self.options.data[i].val()
            }

            $.ajax({
                url: this.options.sourceUrl,
                type: "GET",
                dataType: "json",
                data: dados,
                success: function (data) {
                    var items = data.data;
                    self._totalItems = data.meta.total;
                    // loaderAjax(self.element, "input", true);
                    // Create a menu item for each of the items on the page.
                    if (items != undefined) {
                        response($.map(items, function (item) {
                            return item
                        }));
                    }
                }
            });
        },
        focus: function () {

            // prevent value inserted on focus
            return false;
        }
    },
    search: function (value, event) {

        // Start a fresh search; Hide pagination panel and reset to 1st page.
        this._pageIndex = 0;

        $.ui.autocomplete.prototype.search.call(this, value, event);
    },
    select: function (item) {

        var self = this;

        // Apply the item's label to the autocomplete textbox.
        this._value(item.label);

        // Keep track of the selected item.
        self._previousSelectedItem = item;
    },
    close: function (event) {
        // Close the pagination panel when the selection pop-up is closed.
        this._paginationContainerElement.css('display', 'none');
        $.ui.autocomplete.prototype.close.call(this, event);
    },
    _previousSelectedItem: null,
    _totalPages: null,
    _totalItems: null,
    _pageIndex: 0,
    _create: function () {
        var self = this;
        // Create the DOM structure to support the paginated autocomplete.

        this.element.after("<div class='ui-autocomplete-pagination-results'></div>");
        this._resultsContainerElement = this.element.next("div.ui-autocomplete-pagination-results");
        this._resultsContainerElement.after("<div style='display:none; padding-top: 5px; padding-left: 5px; position: absolute; min-width:320px; z-index: 101;' class='ui-autocomplete-pagination-container'>" +
            "<div style='float:left; width:65%;' class='ui-autocomplete-pagination-details'>Showing 1-10 of 1000 items.</div>" +
            '<div class="btn-group" role="group" aria-label="Basic example">' +
            "<button type='button' class='btn btn-default btn-sm previous-page'><i class='fas fa-arrow-left'></i></button>" +
            "<button type='button' class='btn btn-default btn-sm next-page'><i class='fas fa-arrow-right'></i></button>" +
            "</div>" +
            "</div>");
        this._paginationContainerElement = this._resultsContainerElement.next("div.ui-autocomplete-pagination-container");
        this._nextPageElement = this._paginationContainerElement.find("button.next-page");
        this._previousPageElement = this._paginationContainerElement.find("button.previous-page");
        this._paginationDetailsElement = this._paginationContainerElement.find("div.ui-autocomplete-pagination-details");

        this._nextPageElement.button({text: false, icons: {primary: "ui-icon ui-icon-arrowthick-1-e"}});
        this._previousPageElement.button({text: false, icons: {primary: "ui-icon-arrowthick-1-w"}});

        // Append the menu items (and related content) to the specified element.
        if (this.options.appendTo !== null) {
            this._paginationContainerElement.appendTo(this._resultsContainerElement);
            this._resultsContainerElement.appendTo(this.options.appendTo);
            this.options.appendTo = this._resultsContainerElement;
        } else {
            this.options.appendTo = this._resultsContainerElement;
        }

        // Hide default JQuery Autocomplete details (want to use our own blurb).
        $(this.element).next("span.ui-helper-hidden-accessible").css("display", "none");

        // Event handler(s) for the next/previous pagination buttons.
        this._on(this._nextPageElement, {
            click: this._nextPage
        });
        this._on(this._previousPageElement, {
            click: this._previousPage
        });

        // Event handler(s) for the autocomplete textbox.
        this._on(this.element, {
            blur: function (event) {
                // When losing focus hide the pagination panel
                this._pageIndex = 0;
            },
            paginatedautocompleteopen: function (event) {

                // Autocomplete menu is now visible.

                // Update pagination information.

                var self = this,
                    paginationFrom = null,
                    paginationTo = null,
                    menuOffset = this.menu.element.offset();

                self._totalPages = Math.ceil(self._totalItems / self.options.pageSize);

                paginationFrom = self._pageIndex * self.options.pageSize + 1;
                paginationTo = ((self._pageIndex * self.options.pageSize) + self.options.pageSize);

                if (paginationTo > self._totalItems) {
                    paginationTo = self._totalItems;
                }

                // Align the pagination container with the menu.
                this._paginationContainerElement.offset({top: menuOffset.top, left: menuOffset.left});

                // Modify the list generated by the autocomplete so that it appears below the pagination controls.
                this._resultsContainerElement
                    .find("ul")
                    .css({
                        "padding-top": "40px",
                        "min-width": "300px",
                        "z-index": "100"
                    });

                this._paginationDetailsElement.html("<!--Mostrando -->" + paginationFrom.toString() + " para " + paginationTo.toString() + " de " + self._totalItems.toString() + " itens.");
            }
        });

        // Event handler(s) for the pagination panel.
        this._on(this._paginationContainerElement, {

            mousedown: function (event) {

                // The following will prevent the pagination panel and selection menu from losing focus (and disappearing).

                // Prevent moving focus out of the text field
                event.preventDefault();

                // IE doesn't prevent moving focus even with event.preventDefault()
                // so we set a flag to know when we should ignore the blur event
                this.cancelBlur = true;
                this._delay(function () {
                    delete this.cancelBlur;
                });
            }
        });

        // Now we're going to let the default _create() to do it's thing. This will create the autocomplete pop-up selection menu.
        $.ui.autocomplete.prototype._create.call(this);

        // Event handler(s) for the autocomplete pop-up selection menu.
        this._on(this.menu.element, {

            menuselect: function (event, ui) {

                var item = ui.item.data("ui-autocomplete-item");    // Get the selected item.

                this.element.trigger('selected', item)
                this.select(item);
            }
        });

    },
    _nextPage: function (event) {
        if (this._pageIndex < this._totalPages - 1) {
            this._pageIndex++;
            $.ui.autocomplete.prototype._search.call(this, this.term);
        }
    },
    _previousPage: function (event) {
        if (this._pageIndex > 0) {
            this._pageIndex--;
            $.ui.autocomplete.prototype._search.call(this, this.term);
        }
    },
    _change: function (event) {

        // Clear the textbox if an item wasn't selected from the menu.
        if (((this.selectedItem === null) && (this._previousSelectedItem === null)) ||
            (this.selectedItem === null) && (this._previousSelectedItem !== null) && (this._previousSelectedItem.label !== this._value())) {

            // Clear values.
            //this._value("");
        }

        $.ui.autocomplete.prototype._change.call(this, event);
    },
    _destroy: function () {
        this._paginationContainerElement.remove();
        this._resultsContainerElement.remove();
        $.ui.autocomplete.prototype._destroy.call(this);
    },
    __response: function (content) {
        var self = this;

        self._totalItemsOnPage = content.length;

        if (self._totalItemsOnPage > 0) {
            self._paginationContainerElement.css('display', 'inline');
        } else {
            self._paginationContainerElement.css('display', 'none');
        }

        $.ui.autocomplete.prototype.__response.call(this, content);
    }
});

$.widget.bridge("paginatedAutocomplete", $.scottsJewels.paginatedAutocomplete);
