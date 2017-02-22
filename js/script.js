(function (OC, window, $, undefined) {
'use strict';

$(document).ready(function () {

var translations = {
    newLink: $('#new-link-string').text()
};

// this links object holds all our links
var Links = function (baseUrl) {
    this._baseUrl = baseUrl;
    this._links = [];
    this._activelink = undefined;
};

Links.prototype = {
    load: function (id) {
        var self = this;
        this._links.forEach(function (link) {
            if (link.id === id) {
                link.active = true;
                self._activelink = link;
            } else {
                link.active = false;
            }
        });
    },
    getActive: function () {
        return this._activelink;
    },
    removeActive: function () {
        var index;
        var deferred = $.Deferred();
        var id = this._activelink.id;
        this._links.forEach(function (link, counter) {
            if (link.id === id) {
                index = counter;
            }
        });

        if (index !== undefined) {
            // delete cached active link if necessary
            if (this._activelink === this._links[index]) {
                delete this._activelink;
            }

            this._links.splice(index, 1);

            $.ajax({
                url: this._baseUrl + '/' + id,
                method: 'DELETE'
            }).done(function () {
                deferred.resolve();
            }).fail(function () {
                deferred.reject();
            });
        } else {
            deferred.reject();
        }
        return deferred.promise();
    },
    create: function (link) {
        var deferred = $.Deferred();
        var self = this;
        $.ajax({
            url: this._baseUrl,
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(link)
        }).done(function (link) {
            self._links.push(link);
            self._activelink = link;
            self.load(link.id);
            deferred.resolve();
        }).fail(function () {
            deferred.reject();
        });
        return deferred.promise();
    },
    getAll: function () {
        return this._links;
    },
    loadAll: function () {
        var deferred = $.Deferred();
        var self = this;
        $.get(this._baseUrl).done(function (links) {
            self._activelink = undefined;
            self._links = links;
            deferred.resolve();
        }).fail(function () {
            deferred.reject();
        });
        return deferred.promise();
    },
    updateActive: function (title, _link) {
        var link = this.getActive();
        link.title = title;
        link.link = _link;

        return $.ajax({
            url: this._baseUrl + '/' + link.id,
            method: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify(link)
        });
    }
};

// this will be the view that is used to update the html
var View = function (links) {
    this._links = links;
};

View.prototype = {
    renderContent: function () {
        var source = $('#content-tpl').html();
        var template = Handlebars.compile(source);
        var html = template({link: this._links.getActive()});

        $('#editor').html(html);

        // handle saves
        var title_field = $('#app-content #title_field');
        var link_field = $('#app-content #link_field');
        var self = this;
        $('#app-content button').click(function () {
            var link_text = link_field.val();
            var title_text = title_field.val();

            self._links.updateActive(title_text, link_text).done(function () {
                self.render();
            }).fail(function () {
                alert('Could not update link, not found');
            });
        });
    },
    renderNavigation: function () {
        var source = $('#navigation-tpl').html();
        var template = Handlebars.compile(source);
        var html = template({links: this._links.getAll()});

        $('#app-navigation ul').html(html);

        // create a new link
        var self = this;
        $('#new-link').click(function () {
            var link = {
                title: translations.newlink,
                link: ''
            };

            self._links.create(link).done(function() {
                self.render();
                $('#editor #title_field').focus();
            }).fail(function () {
                alert('Could not create link');
            });
        });

        // show app menu
        $('#app-navigation .app-navigation-entry-utils-menu-button').click(function () {
            var entry = $(this).closest('.link');
            entry.find('.app-navigation-entry-menu').toggleClass('open');
        });

        // delete a link
        $('#app-navigation .link .delete').click(function () {
            var entry = $(this).closest('.link');
            entry.find('.app-navigation-entry-menu').removeClass('open');

            self._links.removeActive().done(function () {
                self.render();
            }).fail(function () {
                alert('Could not delete link, not found');
            });
        });

        // load a link
        $('#app-navigation .link > a').click(function () {
            var id = parseInt($(this).parent().data('id'), 10);
            self._links.load(id);
            self.render();
            $('#editor #title_field').focus();
        });
    },
    render: function () {
        this.renderNavigation();
        this.renderContent();
    }
};

var links = new Links(OC.generateUrl('/apps/backpack/links'));

var view = new View(links);
links.loadAll().done(function () {
    view.render();
}).fail(function () {
    alert('Could not load links');
});


});

})(OC, window, jQuery);