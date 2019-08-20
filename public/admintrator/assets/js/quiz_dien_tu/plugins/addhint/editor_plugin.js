(function() {
    tinymce.PluginManager.requireLangPack("addhint");
    tinymce.create("tinymce.plugins.AddhintPlugin", {
        init: function(a, b) {
            a.addCommand("mceAddhint", function() {
                var c;
                a.windowManager.open({
                    file: b + "/dialog.htm",
                    width: 350 + parseInt(a.getLang("addhint.delta_width", 0)),
                    height: 200 + parseInt(a.getLang("addhint.delta_height", 0)),
                    inline: 1
                }, {
                    plugin_url: b,
                    marked_string: a.selection.getContent({
                        format: "text"
                    })
                })
            });
            a.addButton("addhint", {
                title: "addhint.desc",
                cmd: "mceAddhint",
                image: b + "/img/addhint.gif"
            });
            a.onNodeChange.add(function(d, c, e) {
                c.setActive("addhint", e.nodeName == "IMG")
            })
        },
        createControl: function(b, a) {
            return null
        },
        getInfo: function() {
            return {
                longname: "Addhint plugin",
                author: "Some author",
                authorurl: "http://tinymce.moxiecode.com",
                infourl: "http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/addhint",
                version: "1.0"
            }
        }
    });
    tinymce.PluginManager.add("addhint", tinymce.plugins.AddhintPlugin)
})();