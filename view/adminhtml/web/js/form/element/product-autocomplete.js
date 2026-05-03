define([
    'underscore',
    'jquery',
    'Magento_Ui/js/form/element/abstract',
    'mage/url'
], function (_, $, Abstract, urlBuilder) {
    'use strict';

    return Abstract.extend({
        defaults: {
            elementTmpl: 'WapplerSystems_FeaturedSlider/form/element/product-autocomplete',
            searchUrl: '',
            searchTerm: '',
            results: [],
            displayLabel: '',
            isLoading: false,
            minChars: 2,
            tracks: {
                searchTerm: true,
                results: true,
                displayLabel: true,
                isLoading: true
            }
        },

        initialize: function () {
            this._super();
            this.searchTerm = '';
            this.results = [];
            if (!this.searchUrl) {
                this.searchUrl = urlBuilder.build('featuredslider/slide/productSearch');
            }
            this._loadInitial();
            return this;
        },

        _loadInitial: function () {
            var self = this;
            var current = this.value();
            if (!current) {
                return;
            }
            $.getJSON(this.searchUrl, {id: current}).done(function (data) {
                if (data.items && data.items.length) {
                    self.displayLabel = self._formatItem(data.items[0]);
                }
            });
        },

        onSearch: function (data, event) {
            var query = $(event.target).val();
            this.searchTerm = query;
            if (!query || query.length < this.minChars) {
                this.results = [];
                return;
            }
            this._fetch(query);
        },

        _fetch: _.debounce(function (query) {
            var self = this;
            self.isLoading = true;
            $.getJSON(this.searchUrl, {q: query}).done(function (data) {
                self.results = (data.items || []).slice();
                self.isLoading = false;
            }).fail(function () {
                self.isLoading = false;
            });
        }, 250),

        select: function (item) {
            this.value(item.id);
            this.displayLabel = this._formatItem(item);
            this.searchTerm = '';
            this.results = [];
        },

        clearSelection: function () {
            this.value('');
            this.displayLabel = '';
            this.searchTerm = '';
            this.results = [];
        },

        _formatItem: function (item) {
            return item.name + ' (SKU: ' + item.sku + ', ID: ' + item.id + ')';
        }
    });
});
