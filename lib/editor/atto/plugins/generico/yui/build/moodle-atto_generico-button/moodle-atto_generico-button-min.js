YUI.add("moodle-atto_generico-button",function(e,t){var n="atto_generico",r="atto_generico",i={INPUTSUBMIT:"atto_media_urlentrysubmit",INPUTCANCEL:"atto_media_urlentrycancel",KEYBUTTON:"atto_generico_templatebutton",HEADERTEXT:"atto_generico_headertext",INSTRUCTIONSTEXT:"atto_generico_instructionstext",TEMPLATEVARIABLE:"atto_generico_templatevariable",FLAVORCONTROL:"flavorcontrol"},s={FLAVORCONTROL:".flavorcontrol"},o='<div id="{{elementid}}_{{innerform}}" class="mdl-align"><h4 class="'+i.HEADERTEXT+'">{{headertext}} {{name}}</h4>'+'<div class="'+i.INSTRUCTIONSTEXT+'">{{instructions}}</div>'+"</div>",u='<div id="{{elementid}}_{{innerform}}" class="mdl-align"><h4 class="'+i.HEADERTEXT+'">{{headertext}}</h4>'+"</div>",a='<div id="{{elementid}}_{{innerform}}" class="atto_generico_buttons mdl-align"><button class="'+i.KEYBUTTON+'_{{templateindex}}">{{name}}</button>'+"</div>",f='<div id="{{elementid}}_{{innerform}}" class="mdl-align">{{variable}}&nbsp;<input type="text" class="'+i.TEMPLATEVARIABLE+'_{{variableindex}} atto_generico_field" value="{{defaultvalue}}"></input>'+"</div>",l='<div id="{{elementid}}_{{innerform}}" class="mdl-align">{{variable}}</div>',c='<select class="'+i.TEMPLATEVARIABLE+'_{{variableindex}} atto_generico_field"></select>',h='<option value="{{option}}">{{option}}</option>',p='<form class="atto_form"><div id="{{elementid}}_{{innerform}}" class="mdl-align"><button class="'+i.INPUTSUBMIT+'">{{inserttext}}</button>'+"</div>"+"</form>";e.namespace("M.atto_generico").Button=e.Base.create("button",e.M.editor_atto.EditorPlugin,[],{_currentSelection:null,initializer:function(){if(this.get("disabled"))return;if(this.get("customicon")){var e=decodeURIComponent(this.get("customicon")),t="atto_generico";this.addButton({iconurl:e,buttonName:t,callback:this._displayDialogue,callbackArgs:t})}else{var t="iconone";this.addButton({icon:"ed/"+t,iconComponent:"atto_generico",buttonName:t,callback:this._displayDialogue,callbackArgs:t})}},_displayDialogue:function(t,r){t.preventDefault();var i=400,s=this.getDialogue({headerContent:M.util.get_string("dialogtitle",n),width:i+"px",focusAfterHide:r});s.width!==i+"px"&&s.set("width",i+"px");var o=e.Node.create("<div></div>"),a=e.Handlebars.compile(u),f=e.Node.create(a({headertext:M.util.get_string("chooseinsert",n)}));o.append(f);var l=this._getButtonsForKeys(r);e.Array.each(l,function(e){o.append(e)},o),s.set("bodyContent",o),s.show(),this.markUpdated()},_showTemplateForm:function(t,r){t.preventDefault();var i=400,s=this.getDialogue({headerContent:M.util.get_string("dialogtitle",n),width:i+"px"});s.width!==i+"px"&&s.set("width",i+"px");var u=this._getTemplateFields(r),a=this.get("instructions")[r];a=decodeURIComponent(a);if(u&&u.length>0)var f=M.util.get_string("fieldsheader",n);else var f=M.util.get_string("nofieldsheader",n);var l=e.Handlebars.compile(o),c=e.Node.create(l({key:this.get("keys")[r],name:this.get("names")[r],headertext:f,instructions:a})),h=c,p=e.Node.create("<div></div>");p.append(h),e.Array.each(u,function(e){p.append(e)},p);var d=this._getSubmitButtons(r);p.append(d),s.set("bodyContent",p),s.show(),this.markUpdated()},_getSubmitButtons:function(t){var r=e.Handlebars.compile(p),s=e.Node.create(r({elementid:this.get("host").get("elementid"),inserttext:M.util.get_string("insert",n)}));return s.one("."+i.INPUTSUBMIT).on("click",this._doInsert,this,t),s},_getTemplateFields:function(t){var n=[],r=this.get("keys")[t],i=this.get("names")[t],s=this.get("variables")[t],o=this.get("defaults")[t],u=o;return e.Array.each(s,function(t,r){if(t in u&&u[t].indexOf("|")>-1){var i=e.Handlebars.compile(l),s=e.Node.create(i({elementid:this.get("host").get("elementid"),variable:t,defaultvalue:u[t],variableindex:r})),o=e.Handlebars.compile(c),a=e.Node.create(o({variable:t,defaultvalue:u[t],variableindex:r})),p=u[t].split("|"),d="",v=e.Handlebars.compile(h);e.Array.each(p,function(t,n){var r=e.Node.create(v({option:t}));a.appendChild(r)}),s.appendChild(a)}else var m=e.Handlebars.compile(f),s=e.Node.create(m({elementid:this.get("host").get("elementid"),variable:t,defaultvalue:u[t],variableindex:r}));n.push(s)},this),n},_getButtonsForKeys:function(t){var n=[];return e.Array.each(this.get("names"),function(t,r){var s=e.Handlebars.compile(a),o=e.Node.create(s({elementid:this.get("host").get("elementid"),name:t,templateindex:r}));this._form=o,o.one("."+i.KEYBUTTON+"_"+r).on("click",this._showTemplateForm,this,r),n.push(o)},this),n},_getDefArray:function(t){var n=[],r=t.match(/([^=,]*)=("[^"]*"|[^,"]*)/g);return e.Array.each(r,function(e){var t=e.split("=");t&&t.length>1&&(n[t[0]]=t[1].replace(/"/g,""))},this),n},_doInsert:function(t,n){t.preventDefault(),this.getDialogue({focusAfterHide:null}).hide();var r="{GENERICO:type=",s=this.get("keys")[n],o=this.get("names")[n],u=this.get("variables")[n],a=this.get("defaults")[n],f=this.get("ends")[n],l=a;r+='"'+s+'"',e.Array.each(u,function(t,n){var s=e.one("."+i.TEMPLATEVARIABLE+"_"+n),o=s.get("value");o&&o!=l[t]&&(r+=","+t+'="'+o+'"')},this),r+="}",f&&(r+='<br/>{GENERICO:type="'+s+'_end"}'),this.editor.focus(),this.get("host").insertContentAtFocusPoint(r),this.markUpdated()}},{ATTRS:{disabled:{value:!1},keys:{value:null},names:{value:null},variables:{value:null},defaults:{value:null},instructions:{value:null},customicon:{value:null},ends:{value:null}}})},"@VERSION@",{requires:["moodle-editor_atto-plugin"]});