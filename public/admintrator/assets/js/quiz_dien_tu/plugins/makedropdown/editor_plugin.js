(function(){tinymce.PluginManager.requireLangPack("makedropdown");tinymce.create("tinymce.plugins.MakedropdownPlugin",{init:function(a,b){a.addCommand("mceMakeDropdown",function(){var c;a.windowManager.open({file:b+"/dialog.htm",width:300+parseInt(a.getLang("makedropdown.delta_width",0)),height:200+parseInt(a.getLang("makedropdown.delta_height",0)),inline:1},{plugin_url:b,marked_string:a.selection.getContent({format:"text"})})});a.addButton("makedropdown",{title:"makedropdown.desc",cmd:"mceMakeDropdown",image:b+"/img/makedropdown.gif"});a.onNodeChange.add(function(d,c,e){c.setActive("makedropdown",e.nodeName=="IMG")})},createControl:function(b,a){return null},getInfo:function(){return{longname:"Makedropdown plugin",author:"Some author",authorurl:"http://tinymce.moxiecode.com",infourl:"http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/makedropdown",version:"1.0"}}});tinymce.PluginManager.add("makedropdown",tinymce.plugins.MakedropdownPlugin)})();