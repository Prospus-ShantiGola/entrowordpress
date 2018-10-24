function _setOptin(callbackMode, customEventTrigger) {
    var formType = $ZC("#formType").val();
    if ("QuickForm" !== formType) {
        $ZC("table#listRelTable td").length > 0 && $ZC("table#listRelTable td").find(':checkbox[name="listCheckBox"]').unbind("click").bind("click", getcheckedListIds);
        var campaignUrl = $ZC("#zc_Url").val();
        $ZC(".dateClass").length > 0 && ($ZC(".dateClass").removeClass("hasDatepicker"),
        "undefined" != typeof jQuery.ui && $ZC(".dateClass").datepicker({
            changeYear: !0,
            changeMonth: !0,
            yearRange: "-100:+50",
            showOn: "both",
            buttonImage: "//" + campaignUrl + "/images/spacer.gif",
            buttonImageOnly: !0
        }),
        $ZC("img.ui-datepicker-trigger").css({
            "z-index": "1",
            "background-position": "0px -153px",
            width: "16px",
            height: "18px",
            "vertical-align": "middle",
            "background-image": "url(//" + campaignUrl + "/images/icons.png)",
            border: "0px"
        }),
        $ZC("img.ui-datepicker-trigger").css({
            position: "relative"
        }),
        $ZC("img.ui-datepicker-trigger").css({
            "float": "right"
        }),
        $ZC("img.ui-datepicker-trigger").css({
            top: "-22px"
        }),
        $ZC("img.ui-datepicker-trigger").css({
            right: "15px"
        }),
        $ZC("#ui-datepicker-div").css({
            "z-index": "100"
        }),
        $ZC("#ui-datepicker-div").css({
            position: "relative"
        }),
        $ZC("#ui-datepicker-div").css({
            display: "none"
        }))
    }
    $ZC(document).ready(function() {
        "button" !== $ZC("[id='zcWebOptin']").attr("type") && $ZC("[id='zcWebOptin']").attr("onclick", "return false"),
        $ZC("[id='zcampaignOptinForm']").keypress(function(event) {
            return 13 == event.keyCode ? (saveOptin($ZC(this).closest("form").find("#zcWebOptin"), callbackMode, customEventTrigger),
            !1) : void 0
        }),
        void 0 !== jQuery && ($ = jQuery),
        void 0 !== $ZC && ($ = $ZC)


         $ZC("#closeSuccess").on("click", function() {
           // alert('sas')
            closeSuccessPopup()
        });
    }),
    $ZC("[id='zcWebOptin']").unbind("click").bind("click", function() {
        $ZC("#zcOptinOverLay").bind("click", function() {
            closeSuccessPopup()
        }),

        $ZC("body").bind("keyup", function(event) {
            (27 === event.keyCode || "27" === event.keyCode) && closeSuccessPopup()
        }),
        saveOptin($ZC(this), callbackMode, customEventTrigger)
    })
}


function referenceSetter(imgRefAttr) {
    imgRef = imgRefAttr
}
function validateSignupForm(formMode, thi) {
    var _form = thi.closest("form")
      , cn = (_form.find("#edit_mode").val(),
    _form.find("*"));
    _form.attr("action");
    var brClr = _form.find("#fieldBorder").val();
    txtArea = _form[0].getElementsByTagName("textarea"),
    _form.find("#errorMsgDiv").length > 0 ? _form.find("#errorMsgDiv").hide() : $ZC("#errorMsgDiv").hide();
    var $bs, fieldCheckArray = new Array('"',"\\","<",">"), borderStyle = $ZC("[changeitem='SIGNUP_FORM_FIELD']").css("border-style"), isNoBorder = "none" === borderStyle, temp = "true";
    cn.each(function() {
        var fieldname = this.name
          , span_ele = _form.find("#dt_" + fieldname);
        if (null != span_ele && void 0 != span_ele && span_ele.length > 0) {
            span_val = span_ele.text();
            var ele = span_val.split(",")
              , datatype = ele[0]
              , is_man = ele[1]
              , uitype = ele[2]
              , displayLabel = ele[3]
              , defaultPlaceHolder = ele[5]
              , fieldValue = this.value;
            if (fieldValue = $ZC.trim(fieldValue),
            _form.find("#error_" + fieldname).html(" "),
            $bs = _form.find("[name='" + fieldname + "']"),
            isNoBorder && ($bs = $bs.closest("div")),
            "saveOptin" == formMode && $bs.css({
                "border-color": brClr
            }),
            defaultPlaceHolder == fieldValue && $bs.val(""),
            ("true" == is_man && "" == fieldValue || "true" == is_man && (10 == uitype || 4 == uitype || 12 == uitype)) && (10 != uitype && 4 != uitype && 12 != uitype || !$ZC("input[name=" + fieldname + "]").is(":checked") ? ($bs.parent().css({
                "border-color": "#f2644d"
            }),
            $bs.parent().css({
                "border-style": "solid"
            }),
            $bs.parent().css({
                "border-width": "1px"
            }),
            isNoBorder ? $bs.on("keyup", function(event) {
                testIfValidChar(event) && $ZC(this).css("border-style", "none")
            }) : $bs.on("keyup", function(event) {
                testIfValidChar(event) && $ZC(this).css({
                    "border-color": brClr
                })
            }),
            temp = "false") : (isNoBorder ? $bs.on("keyup", function(event) {
                testIfValidChar(event) && $ZC(this).css("border-style", "none")
            }) : $bs.on("keyup", function(event) {
                testIfValidChar(event) && $ZC(this).css({
                    "border-color": brClr
                })
            }),
            $bs.parent().css({
                border: ""
            }))),
            splCharValidationForSignupForm(fieldValue, fieldCheckArray, $bs.attr("id"), _form) || ($bs.css({
                "border-color": "#f2644d"
            }),
            $bs.css({
                "border-style": "solid"
            }),
            $bs.css({
                "border-width": "1px"
            }),
            isNoBorder ? $bs.on("keyup", function(event) {
                testIfValidChar(event) && $ZC(this).css("border-style", "none")
            }) : $bs.on("keyup", function(event) {
                testIfValidChar(event) && $ZC(this).css({
                    "border-color": brClr
                })
            }),
            temp = "false"),
            2 == datatype || 5 == datatype)
                isNaN(fieldValue) && ($bs.css({
                    "border-color": "#f2644d"
                }),
                $bs.css({
                    "border-style": "solid"
                }),
                $bs.css({
                    "border-width": "1px"
                }),
                isNoBorder ? $bs.on("keyup", function(event) {
                    testIfValidChar(event) && $ZC(this).css("border-style", "none")
                }) : $bs.on("keyup", function(event) {
                    testIfValidChar(event) && $ZC(this).css({
                        "border-color": brClr
                    })
                }),
                temp = "false");
            else if (9 == uitype) {
                var urlRegex = /(|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
                "" == fieldValue || urlRegex.test(fieldValue) || ($bs.css({
                    "border-color": "#f2644d"
                }),
                $bs.css({
                    "border-style": "solid"
                }),
                $bs.css({
                    "border-width": "1px"
                }),
                isNoBorder ? $bs.on("keyup", function(event) {
                    testIfValidChar(event) && $ZC(this).css("border-style", "none")
                }) : $bs.on("keyup", function(event) {
                    testIfValidChar(event) && $ZC(this).css({
                        "border-color": brClr
                    })
                }),
                temp = "false")
            } else
                1 == datatype && 6 == uitype && "" != fieldValue && (emailPatternCheck(fieldValue, displayLabel) || ($bs.css({
                    "border-color": "#f2644d"
                }),
                $bs.css({
                    "border-style": "solid"
                }),
                $bs.css({
                    "border-width": "1px"
                }),
                isNoBorder ? $bs.on("keyup", function(event) {
                    testIfValidChar(event) && $ZC(this).css("border-style", "none")
                }) : $bs.on("keyup", function(event) {
                    testIfValidChar(event) && $ZC(this).css({
                        "border-color": brClr
                    })
                }),
                temp = "false"))
        }
    });
    for (var i = 0; i < txtArea.length; i++) {
        var span_ele = document.getElementById("dt_" + txtArea[i].name);
        if (null != span_ele) {
            span_val = span_ele.innerHTML;
            var ele = span_val.split(",")
              , datatype = ele[0]
              , is_man = ele[1]
              , uitype = ele[2]
              , field_Value = (ele[3],
            txtArea[i].value)
              , fieldValue = field_Value
              , fieldname = txtArea[i].name;
            if (_form.find("#error_" + fieldname).html(" "),
            _form.find("[name='" + fieldname + "']").css({
                "border-color": ""
            }),
            "saveOptin" == formMode) {
                var brClr = _form.find("#fieldBorder").val();
                _form.find("#" + fieldname).css({
                    "border-color": brClr
                })
            }
            "true" == is_man && "" == fieldValue && (_form.find("#" + fieldname).css({
                "border-color": "#f2644d"
            }),
            temp = "false"),
            6 == uitype || 9 == uitype || splCharValidationForSignupForm(fieldValue, fieldCheckArray, txtArea[i].id, _form) || (_form.find("#" + fieldname).css({
                "border-color": "#f2644d"
            }),
            temp = "false"),
            1 == datatype && 5 == uitype && fieldValue.length >= 300 && (_form.find("#" + fieldname).css({
                "border-color": "#f2644d"
            }),
            temp = "false")
        }
    }
    if ($ZC("#captchaText").is(":visible")) {
        var digest = ""
          , capUrl = $ZC("#captchaDiv").find("img").attr("src")
          , index = capUrl.indexOf("digest=") + 7;
        digest = capUrl.substring(index, capUrl.length);
        var capText = $ZC("#captchaText").val()
          , captchaCheck = captchaCheckForOptin(digest, capText)
          , brClr = _form.find("#fieldBorder").val();
        0 == captchaCheck && (_form.find("#captchaText").css({
            "border-color": "#f2644d"
        }),
        _form.find("#captchaText").css("border-style", "solid"),
        _form.find("#captchaText").css("border-width", "1px"),
        isNoBorder ? _form.find("#captchaText").on("keyup", function(event) {
            testIfValidChar(event) && $ZC(this).css("border-style", "none")
        }) : _form.find("#captchaText").on("keyup", function(event) {
            testIfValidChar(event) && $ZC(this).css({
                "border-color": brClr
            })
        }),
        temp = "false",
        loadCaptcha("", _form.find("#captchaDiv")))
    }
    return "false" == temp ? (_form.parent().find("#errorMsgDiv").fadeIn(),
    $ZC("html, body").animate({
        scrollTop: _form.closest("#customForm").find("#errorMsgDiv").offset().top
    }, 500),
    _form.find("#workInfoDetails").show(),
    !1) : !0
}
function emailPatternCheck(email) {
    var re = new RegExp(/^[a-zA-Z0-9\_\-\'\.\+]+\@[a-zA-Z0-9\-\_]+(?:\.[a-zA-Z0-9\-\_]+){0,3}\.(?:[a-zA-Z0-9\-\_]{2,15})$/);
    return re.test(email) ? !0 : !1
}
function splCharValidationForSignupForm(fieldValue, splCharArray, id, _form) {
    for (i = 0; i < splCharArray.length; i++)
        if (fieldValue.indexOf(splCharArray[i]) >= 0)
            return _form.find("#" + id).focus(),
            !1;
    return !0
}
function saveOptin(thi, callbackMode, customEventTrigger) {

    if (validateSignupForm("saveOptin", thi)) {
           $(".flex-loader").removeClass("hide");
        var _form = thi.closest("form");
        customEventTrigger && (callbackMode || customEventTrigger()),
        "_zcSignup" === _form.attr("target") && _form.submit(function(event) {
            if (_form.find("#Zc_SignupSuccess").hide(),
            "" !== _form.find("[name='CONTACT_EMAIL']").val()) {
                _form.find("[name='CONTACT_EMAIL']").val(_form.find("[name='CONTACT_EMAIL']").val().trim());
                var paramData = $ZC(this).serialize();
                paramData = getCorrectSerializedData(paramData),
                paramData += "&responseMode=inline";
                var formAction = $ZC(this).attr("action");
                if (null != formAction && 0 != formAction.indexOf("http")) {
                    var protocol = "https:";
                    0 != formAction.indexOf("//") && (protocol += "//"),
                    formAction = protocol + formAction
                }
                resetSignupForm(_form),
                $ZC.get(formAction, paramData, function(data) {
                    dataParsing(data, callbackMode, customEventTrigger, _form)
                })
            }
            return event.preventDefault(),
            !1
        }),
        _form.submit(),
        callbackMode && customEventTrigger && callbackMode && customEventTrigger()

    } 
    else
    {
        loadCaptcha(void 0, $ZC(thi).closest("#customForm").find("#refImage"))
    }
     // $(".flex-loader").addClass("hide");
}
function getcheckedListIds() {
    var listIds = []
      , _form = $ZC(this).closest("form");
    _form.find("input:checkbox[name=listCheckBox]:checked").each(function(index, data) {
        listIds.push(data.value)
    }),
    _form.find("#allCheckedListIds").val(listIds)
}
function clearField(id) {
    $ZC("#" + id).find(":input").each(function() {
        var type = this.type
          , tag = this.tagName.toLowerCase();
        "text" == type || "textarea" == tag || "file" == type ? this.value = "" : ("checkbox" == type || "radio" == type) && (this.checked = !1)
    })
}
function closeSuccessPopup() {
    $ZC("#zcOptinSuccessPopup").fadeOut(),
    $ZC("#zcOptinOverLay").hide()
}
function captchaCheckForOptin(digest, capText) {
    var result = !1
      , campaignsUrl = $ZC("#zc_Url").val();
    if (void 0 != campaignsUrl && campaignsUrl.indexOf("http") < 0) {
        var protocol = "https:";
        campaignsUrl = protocol + "//" + campaignsUrl
    }
    var action_url = campaignsUrl + "/campaigns/CaptchaVerify.zc"
      , jsonObj = {};
    return jsonObj.digest = digest,
    jsonObj.capText = capText,
    jsonObj.mode = "verify",
    $ZC.ajax({
        type: "get",
        url: action_url,
        data: jsonObj,
        async: !1,
        success: function(msg) {
            var res = msg;
            result = res.indexOf("failure") > -1 ? !1 : !0
        }
    }),
    result
}
function loadCaptcha(url, imgRef) {
    if (void 0 !== url && "" !== url ? captchaUrl = url : ("" === url || void 0 === url || "undefined" === url || "null" === url) && (captchaUrl = $ZC("#zc_Url").val() + "/campaigns/CaptchaVerify.zc?mode=generate"),
    captchaUrl.indexOf("http") < 0) {
        var protocol = "https:";
        captchaUrl = protocol + "//" + captchaUrl
    } else
        captchaUrl.replace("http:", "https:");
    var custDivRef;
    custDivRef = void 0 != imgRef ? $ZC(imgRef).closest("#customForm") : $ZC("[id='customForm']"),
    $ZC.get(captchaUrl, {}, function(msg) {
        $ZC(custDivRef).find("#captchaDiv").html(msg),
        $ZC(custDivRef).find("#captchaDiv img").css("max-width", "200px"),
        $ZC(custDivRef).find("#captchaDiv").find("img").css("width", "100%")
    })
}
function trackSignupEvent(trackCode, action) {
    var signupFormIx = $ZC("#zc_formIx").val()
      , zx = $ZC("#cmpZuid").val()
      , viewFrom = $ZC("#viewFrom").val();
    (null === viewFrom || void 0 === viewFrom || "" === viewFrom) && (viewFrom = "URL_ACTION");
    var jsonObj = {};
    void 0 == action && (action = "view"),
    (void 0 == trackCode || "" == trackCode) && (trackCode = $ZC("#zc_trackCode").val()),
    jsonObj.category = "update",
    jsonObj.action = action,
    jsonObj.trackingCode = trackCode,
    jsonObj.viewFrom = viewFrom,
    jsonObj.zx = zx,
    jsonObj.signupFormIx = signupFormIx;
    var campaignsUrl = $ZC("#zc_Url").val();
    if (void 0 != campaignsUrl && campaignsUrl.indexOf("http") < 0) {
        var protocol = window.location.protocol;
        protocol.indexOf("http") < 0 && (protocol = "http:"),
        campaignsUrl = protocol + "//" + campaignsUrl
    }
    var action_url = campaignsUrl + "/campaigns/TrailEvent.zc";
    $ZC.post(action_url, jsonObj, function() {})
}
function signupformSetPrefillValues(res) {
    "" != res && $ZC.each(res, function(key, data) {
        var jsonArr = JSON.parse(data)
          , fldVal = jsonArr.fld_val;
        "null" == fldVal && (fldVal = "");
        var fldUitype = jsonArr.uitype;
        if (5 == fldUitype)
            fldVal = fldVal.replace(/<br>/gi, "\n"),
            $ZC("#zcampaignOptinForm").find("[name=" + key + "]").val(fldVal);
        else if (4 == fldUitype || 12 == fldUitype)
            fldVal = fldVal.toLowerCase(),
            "yes" == fldVal || "true" == fldVal || "on" == fldVal ? $ZC("#zcampaignOptinForm").find("[name=" + key + "]").attr("checked", !0) : $ZC("#zcampaignOptinForm").find("[name=" + key + "]").attr("checked", !1);
        else if (10 == fldUitype)
            $ZC("input[value='" + fldVal + "']").attr("checked", "checked");
        else if (13 == fldUitype) {
            var multiSelect = fldVal.split(";");
            for (i = 0; i < multiSelect.length; i++)
                $ZC("[name=" + key + "]").find("option[value=" + multiSelect[i] + "]").attr("selected", !0)
        } else if (14 == fldUitype) {
            var hour = jsonArr.hour
              , minute = jsonArr.minute
              , ampm = jsonArr.ampm;
            $ZC("#zcampaignOptinForm").find("[name=" + key + "]").val(fldVal),
            void 0 != hour && ($ZC("#" + key + "_hour").find("option[value=" + hour + "]").attr("selected", "selected"),
            $ZC("#" + key + "_minute").find("option[value=" + minute + "]").attr("selected", "selected"),
            $ZC("#" + key + "_ampm").find("option[value=" + ampm + "]").attr("selected", "selected"),
            $ZC("#hide_" + key).val(fldVal))
        } else
            $ZC("#zcampaignOptinForm").find("[name=" + key + "]").val(fldVal)
    })
}
function removeBackground($elm) {
    $elm.css("background-color", "");
    var id = $elm.attr("id")
      , formType = $ZC("#formType").val();
    "QuickForm" === formType && "SIGNUP_PAGE" === id && (id = "SIGNUP_BODY"),
    $ZC("#" + id + "_background").attr("changeValue", ""),
    "SIGNUP_HEADING" === id ? ($ZC("#rmBgHead").removeClass("selclrnone"),
    $ZC("#rmBgHead").addClass("selclr"),
    $ZC("#bgHead").removeClass("selclr"),
    $ZC("#bgHead").addClass("selclrnone")) : ($ZC("#rmBgBody").removeClass("selclrnone"),
    $ZC("#rmBgBody").addClass("selclr"),
    $ZC("#bgBody").removeClass("selclr"),
    $ZC("#bgBody").addClass("selclrnone"))
}
function themeParse(json, elm) {
    var jsonStr = JSON.stringify(json);
    void 0 === elm && -1 == jsonStr.indexOf("THANKSPAGE") && (elm = $ZC("[name='SIGNUP_PAGE']").parent());
    var custDivRef = $ZC(elm).closest("#customForm");
    ("tm_subscribe_thanks" == elm || "tm_subscribe_thanks_duplicate" == elm || "tm_doptin_thanks" == elm) && (custDivRef = $ZC("#" + elm));
    var previewApply = $ZC(elm).attr("id");
    (void 0 === $ || null === $) && ($ = $ZC),
    $ZC.each(json, function(key, data) {
        "FOOTER" == key || "HEADER" == key ? $ZC.each(data, function(cssKey) {
            "width" == cssKey && ("FOOTER" == key ? $ZC("#F_INNER").css(data.width) : "HEADER" == key && $ZC("#H_INNER").css(data.width))
        }) : void 0 !== elm ? ($ZC(custDivRef).find("#" + key).css(data),
        $ZC(custDivRef).find("[name=" + key + "]").css(data)) : ($ZC(custDivRef).find("#" + key).css(data),
        $ZC(custDivRef).find("[name=" + key + "]").css(data),
        (void 0 == custDivRef || custDivRef.length <= 0) && ($ZC("#" + key).css(data),
        $ZC("[name=" + key + "]").css(data))),
        $ZC(custDivRef).find("[changeItem=" + key + "]").css(data),
        (void 0 == custDivRef || custDivRef.length <= 0) && $ZC(custDivRef).find("[changeItem=" + key + "]").css(data),
        $ZC.each(data, function(cssKey, val) {
            var signupTmplName = $ZC("#signupTmplName").val();
            if (void 0 != signupTmplName && signupTmplName.indexOf("quick_form") > -1 && "SIGNUP_PAGE" == key && (key = "SIGNUP_BODY"),
            "SIGNUP_BACKGROUND" == key) {
                $ZC("[identity='bgImageTools']").show(),
                $ZC("[id='bgProperties']").hide(),
                $ZC("[id='addImagePanel']").hide();
                var selector = ($ZC("#formType").val(),
                $ZC(custDivRef).find("[id='SIGNUP_PAGE']"));
                if ("BgImgUrl" == cssKey)
                    return selector.css("background-image", 'url("' + val + '")'),
                    $ZC("#bgImgUrl").val(val),
                    void $ZC("#bgImgUrl").attr("changevalue", val);
                if ("BgImgName" == cssKey)
                    return $ZC("#bgImgName").val(val),
                    $ZC("#bgImgName").attr("changevalue", val),
                    $ZC("[name='bgImgName']").text(val),
                    void $ZC("[id='bgProperties']").attr("title", val);
                if ("positionX" == cssKey) {
                    val = val.replace("%", ""),
                    $ZC("[identity='bgImageTools']").find("[changeType='positionX']").val(val),
                    $ZC("[identity='bgImageTools']").find("[changeType='positionX']").attr("changeValue", val),
                    val += "%";
                    var bgPosition = selector.css("background-position");
                    if (void 0 != bgPosition) {
                        var bgPositionY = bgPosition.substring(bgPosition.indexOf(" "), bgPosition.length);
                        selector.css("backgroundPosition", val + "% " + bgPositionY)
                    }
                    return
                }
                if ("positionY" == cssKey) {
                    val = val.replace("%", ""),
                    $ZC("[identity='bgImageTools']").find("[changeType='positionY']").val(val),
                    $ZC("[identity='bgImageTools']").find("[changeType='positionY']").attr("changevalue", val),
                    val += "%";
                    var bgPosition = selector.css("background-position");
                    if (void 0 != bgPosition) {
                        var bgPositionX = bgPosition.substring(0, bgPosition.indexOf(" "));
                        selector.css("backgroundPosition", bgPositionX + " " + val)
                    }
                    return
                }
                if ("size" == cssKey)
                    return "" === val && (val = "100%"),
                    $ZC("[name='SIGNUP_BG_SIZE']").val(replaceAll(val, "%", "")),
                    $ZC("[name='SIGNUP_BG_SIZE']").attr("changevalue", val),
                    val.indexOf("%") < 0 && (val += "%"),
                    void ("cover" === replaceAll(val, "%", "") ? ($ZC("#backgroundFit").length > 0 && !$ZC("#backgroundFit").is(":checked") && $ZC("#backgroundFit").click(),
                    selector.css("background-size", replaceAll(val, "%", ""))) : selector.css("background-size", replaceAll(val, "%", "") + "%"));
                if ("bgRepeat" == cssKey)
                    return selector.css("background-repeat", ""),
                    selector.css("background-repeat", val),
                    "" === val && (val = "repeat"),
                    "repeat" === val && (val = "Repeat Both X And Y"),
                    $ZC("[identity='bgImageTools']").find("#SIGNUP_BACKGROUND_bgRepeat").val(val),
                    $ZC("[identity='bgImageTools']").find("#SIGNUP_BACKGROUND_bgRepeat").attr("changevalue", val),
                    void applyChangeSelection($ZC("[identity='bgImageTools']").find("#SIGNUP_BACKGROUND_bgRepeat"))
            }
            var changeType = cssKey;
            if ("background-color" == changeType)
                changeType = "background";
            else if ("color" === changeType)
                changeType = "color";
            else if ("border-color" === changeType)
                changeType = "border";
            else if ("border-radius" === changeType)
                changeType = "borderRadius";
            else if ("border-style" === changeType)
                changeType = "borderStyle";
            else if ("border-width" === changeType)
                changeType = "borderWidth";
            else if ("font-family" === changeType)
                changeType = "fontfamily";
            else if ("font-size" === changeType)
                changeType = "fontsize";
            else if ("font-size" === changeType)
                changeType = "fontsize";
            else if ("align" === changeType)
                changeType = "text-align";
            else if ("border-bottom-color" === changeType) {
                var borderVal = val.substring(val.indexOf("#"), val.length);
                $ZC("#signupThemeToolsDiv").find("#" + key + "_border").css("background-color", borderVal),
                $ZC("#signupThemeToolsDiv").find("#" + key + "_border").attr("changeValue", borderVal)
            }
            $ZC("#signupThemeToolsDiv").find("#" + key + "_" + changeType).attr("changeValue", val),
            "SIGNUP_BODY" !== key || "color" !== changeType && "fontsize" !== changeType && "fontfamily" !== changeType || $ZC(custDivRef).find("[name=SIGNUP_FORM_LIST]").css(cssKey, val),
            "background-color" === cssKey || "color" === cssKey || "border-color" === cssKey ? ($ZC("#campaignRightPageLinks").find("#" + key + "_" + changeType).find("[changeType=" + changeType + "]").attr("changeValue", val),
            $ZC("#" + key + "_" + changeType).css("background-color", val),
            "background-color" === cssKey && "" === val && ("SIGNUP_HEADING" == key ? removeBackground($ZC("[name=SIGNUP_HEADING]")) : "SIGNUP_BODY" == key && removeBackground($ZC("[name=SIGNUP_BODY]")))) : ("LOGO" !== key && "SIGNUPFORM" !== key || "width" !== changeType && "height" !== changeType) && "width" !== changeType ? "width" == cssKey ? "HEADER" == key ? ($ZC("#campaignRightPageLinks").find("#HEADER_width").attr("changeValue", val),
            val = val.replace("px", ""),
            $ZC("#campaignRightPageLinks").find("#HEADER_width").attr("value", val)) : ($ZC("#campaignRightPageLinks").find("#FOOTER_width").attr("changeValue", val),
            val = val.replace("px", ""),
            $ZC("#campaignRightPageLinks").find("#FOOTER_width").attr("value", val)) : "logo_width" === cssKey ? ($ZC("[name=themeLogo]").css("width", val + "px"),
            $ZC("#LOGO_width").val(val),
            $ZC("#LOGO_width").attr("changevalue", val),
            "tm_subscribe_thanks" === previewApply && $ZC("#tm_subscribe_thanks").find("[id=thanksTm_ImgBlock]").find("[id=themeLogo]").css("width", val + "px"),
            "tm_subscribe_thanks_duplicate" === previewApply && $ZC("#tm_subscribe_thanks_duplicate").find("[id=thanksExtTm_imgBlock]").find("[id=themeLogo]").css("width", val + "px"),
            "tm_doptin_thanks" === previewApply && $ZC("#tm_doptin_thanks").find("[id=doubleOptin_imgBlock]").find("[id=themeLogo]").css("width", val + "px")) : "text-align" === cssKey ? ($ZC(custDivRef).find("#imgBlock").closest("[name='LOGO_DIV']").css("text-align", val),
            $ZC("[name=LOGO_POS]").val(val),
            $ZC("[name=LOGO_POS]").attr("changevalue", val),
            "" !== val && $ZC("#currentPos").html(val),
            "tm_subscribe_thanks" === previewApply && $ZC("#tm_subscribe_thanks").find("[id=thanksTm_ImgBlock]").attr("text-align", val),
            "tm_subscribe_thanks_duplicate" === previewApply && $ZC("#tm_subscribe_thanks_duplicate").find("[id=thanksExtTm_imgBlock]").attr("text-align", val),
            "tm_doptin_thanks" === previewApply && $ZC("#tm_doptin_thanks").find("[id=doubleOptin_imgBlock]").attr("text-align", val)) : ((null == val || "null" == val) && (val = ""),
            $ZC("#" + key + "_" + changeType).val(val),
            $ZC("#" + key + "_" + changeType).attr("changeValue", val),
            $ZC("#campaignRightPageLinks").find("#" + key + "_" + changeType).attr("changeValue", val)) : (val.indexOf("px") > -1 && (val = val.substring(0, val.indexOf("px"))),
            $ZC("#" + key + "_" + changeType).attr("value", val)),
            ("HEADER" !== key || "FOOTER" !== key) && (key.indexOf("DUPLICATE_") > -1 && (key = key.substring(key.indexOf("DUPLICATE_") + 10, key.length)),
            applyChangeSelection($ZC("#" + key + "_" + changeType)))
        })
    }),
    void 0 != isReady && (isReady = !0,
    $ZC("[name='SIGNUP_PAGE']").fadeIn("slow"),
    $ZC("[name='SIGNUP_BODY']").fadeIn("slow")),
    $ZC("#fieldBorder").val($ZC("[changeItem='SIGNUP_FORM_FIELD']").css("border-color")),
    $("[placeholder]").focus(function() {
        var input = $(this);
        input.val() == input.attr("placeholder") && (input.val(""),
        input.removeClass("placeholder"))
    }).blur(function() {
        var input = $(this);
        ("" == input.val() || input.val() == input.attr("placeholder")) && (input.addClass("placeholder"),
        input.val(input.attr("placeholder")))
    }).blur().parents("form").submit(function() {
        $(this).find("[placeholder]").each(function() {
            var input = $(this);
            input.val() == input.attr("placeholder") && input.val("")
        })
    })
}
function applyChangeSelection(obj) {
    if ($ZC(obj).length > 0) {
        var selVal = $ZC(obj).val();
        "Lucida Console" == selVal ? selVal = "Lucid.." : "Sans-serif" == selVal ? selVal = "Sans-.." : "Trebuchet Ms" == selVal ? selVal = "Trebu.." : "Courier New" == selVal && (selVal = "Couri.."),
        (null == selVal || "null" == selVal) && void 0 != $ZC(obj).find("option") && $ZC(obj).find("option")[0] && (selVal = $ZC(obj).find("option")[0].value),
        $ZC(obj).parent().find("div").text(selVal)
    }
}
function zc_loadForm(domain, optUrl) {
    $ZC("#viewFrom").val("URL_ACTION");
    var tc_codeVal = $ZC("#button_tc_codeVal").val();
    optUrl = optUrl + "&trackingcode=" + tc_codeVal,
    $ZC("#zc_popoverlay").unbind("click").bind("click", function(evt) {
        var target = $ZC(evt.target);
        target.is("#zc_popoverlay") && hideSFPopup()
    }),
    $ZC("body").one("keydown", function(evt) {
        (27 == evt.which || "27" == evt.which) && hideSFPopup()
    }),
    $ZC("#signUpFormInline").load(optUrl, function() {
        $ZC("#SIGNUP_PAGE").css("position", ""),
        $ZC("#SIGNUP_PAGE").fadeIn(),
        $ZC("#zc_popoverlay").fadeIn(function() {
            $ZC(this).css("opacity", "")
        }),
        $ZC(this).prepend("<div id=\"zc_close\" style='position:absolute;cursor:pointer;top:-14px;text-align: right;right: -14px;'><img src='//" + domain + '/images/videoclose.png\' onclick="hideSFPopup()" id="optinPageClose" style=""></div>')
    })
}
function hideSFPopup(elm) {
    void 0 != elm ? $ZC(elm).closest("#zc_popoverlay").is(":visible") && $ZC(elm).closest("#zc_popoverlay").fadeOut() : $ZC("#zc_popoverlay").is(":visible") && $ZC("#zc_popoverlay").fadeOut()
}
function testIfValidChar(event) {
    var charRegx = /[a-zA-Z0-9-_ ]/;
    return charRegx.test(event.keyCode) ? !0 : !1
}
function escapeRegExp(string) {
    return string.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1")
}
function replaceAll(str, find, replace) {
    return str.replace(new RegExp(escapeRegExp(find),"g"), replace)
}
function dataParsing(data, callbackMode, customEventTrigger, _form) {
    var jsonObj = {}
      , hostnameFirstParty = location.hostname;
    jsonObj.hostnameFirstParty = hostnameFirstParty;
    var cookie = document.cookie
      , c_start = cookie.indexOf("zc_cu=");
    if (-1 == c_start)
        cookie = null;
    else {
        c_start = cookie.indexOf("=", c_start) + 1;
        var c_end = cookie.indexOf(";", c_start);
        -1 == c_end && (c_end = cookie.length),
        cookie = unescape(cookie.substring(c_start, c_end))
    }
    jsonObj.cookie = cookie,
    jsonObj.isFromWebsite = "true",
    callbackMode && customEventTrigger && callbackMode && customEventTrigger();
    var parsedJson = "";
    if (data.indexOf("ZC_TYPEJSON") > -1) {
        parsedJson = "string" == typeof data ? JSON.parse(data) : $ZC.parseJSON(data),
        jsonObj.emailid = parsedJson.emailid,
        jsonObj.zsoid = parsedJson.zsoid;
        var protocol = window.location.protocol;
        if (protocol.indexOf("http") < 0 && (protocol = "http:"),
        void 0 !== parsedJson.newOptinResponse && 2 === parsedJson.newOptinResponse)
            parsedJson.webautoresponse && null != cookie && "" != cookie && $.ajax({
                url: protocol + "//maillist-manage.com/ua/addmappingforanonymousandcontacts",
                type: "GET",
                dataType: "jsonp",
                data: jsonObj,
                contentType: "application/javascript",
                xhrFields: {
                    withCredentials: !0
                },
                crossDomain: !0
            }),
            $ZC("#Zc_SignupSuccess").find("#signupSuccessMsg").html(parsedJson.inlineMessage),
            _form.prepend($ZC("#Zc_SignupSuccess").parent()[0]),
            $ZC("#Zc_SignupSuccess").fadeIn(500, function() {
                setTimeout(function() {
                    $ZC("#Zc_SignupSuccess").fadeOut(500)
                }, 3e3)
            });
        else if (void 0 !== parsedJson.newOptinResponse && 1 === parsedJson.newOptinResponse) {
            var targetUrl = parsedJson.targetUrl;
            parsedJson.webautoresponse && null != cookie && "" != cookie ? $.ajax({
                url: protocol + "//maillist-manage.com/ua/addmappingforanonymousandcontacts",
                type: "GET",
                dataType: "jsonp",
                data: jsonObj,
                contentType: "application/javascript",
                success: function() {
                    void 0 !== parsedJson.targetWindow && "_self" === parsedJson.targetWindow ? window.location.href = targetUrl : window.open(targetUrl)
                },
                error: function() {
                    void 0 !== parsedJson.targetWindow && "_self" === parsedJson.targetWindow ? window.location.href = targetUrl : window.open(targetUrl)
                },
                xhrFields: {
                    withCredentials: !0
                },
                crossDomain: !0
            }) : void 0 !== parsedJson.targetWindow && "_self" === parsedJson.targetWindow ? window.location.href = targetUrl : window.open(targetUrl)
        }
    } else if (data.indexOf("ZC_TYPE_2_JSON") > -1) {
        var n = data.indexOf("##ZCJSON##")
          , startIndex = data.indexOf("##ZCJSONSTART##") + 15
          , details = data.substring(startIndex, n);
        if (data = data.substring(n + 10),
        parsedJson = JSON.parse(details),
        void 0 !== parsedJson.ZC_NEWOPTINRESPONSE && 0 === parsedJson.ZC_NEWOPTINRESPONSE) {
            jsonObj.emailid = parsedJson.emailid,
            jsonObj.zsoid = parsedJson.zsoid;
            var protocol = window.location.protocol;
            if (protocol.indexOf("http") < 0 && (protocol = "http:"),
            parsedJson.webautoresponse && null != cookie && "" != cookie && $.ajax({
                type: "GET",
                dataType: "jsonp",
                data: jsonObj,
                contentType: "text/html",
                url: protocol + "//maillist-manage.com/ua/addmappingforanonymousandcontacts",
                xhrFields: {
                    withCredentials: !0
                },
                crossDomain: !0
            }),
            void 0 !== parsedJson.ZC_TARGETWINDOW && "_self" === parsedJson.ZC_TARGETWINDOW)
                _form.closest("#signUpFormInline").is(":visible") ? ($ZC("head").remove(),
                $ZC("body").html(data)) : (_form.closest("body").html(data),
                window.parent.postMessage(data, "*"));
            else if (void 0 !== parsedJson.ZC_TARGETWINDOW && "_blank" === parsedJson.ZC_TARGETWINDOW) {
                var myWindow = window.open("")
                  , title = document.title;
                myWindow.document.write("<!DOCTYPE HTML><html><head><title>" + title + "</title></head>"),
                myWindow.document.write("<body>" + data + "</body>"),
                myWindow.document.write("</html>"),
                myWindow.window.history.pushState({
                    html: "",
                    pageTitle: ""
                }, "", window.location.href)
            } else
                window.self !== window.top ? $ZC("#zcOptinSuccessPanel").html(data).promise().done(function() {
                    window.parent.postMessage($("body").html(), "*")
                }) : ($ZC("#zcOptinOverLay").css("height", "100%"),
                $ZC("#zcOptinOverLay").css("width", "100%"),
                $ZC("#zcOptinOverLay").fadeIn(function() {
                    $ZC("#zcOptinSuccessPanel").html(data).promise().done(function() {
                         $(".flex-loader").addClass("hide");
                        $ZC("#zcOptinSuccessPopup").fadeIn()
                    })
                }))
        }
    } else if (data.lastIndexOf("##ZCJSON##") > -1) {
        var n = data.lastIndexOf("##ZCJSON##")
          , startIndex = data.indexOf("##ZCJSONSTART##") + 15;
        data = data.substring(n + 10),
        $ZC("#zcOptinSuccessPopup").fadeIn();
        var arrayPageSize1 = new Array($ZC(document).width(),$ZC(document).height(),$ZC(window).width(),$ZC(window).height());
        $ZC("#zcOptinOverLay").height(arrayPageSize1[1]),
        $ZC("#zcOptinOverLay").show(),
        $ZC("#zcOptinSuccessPanel").html(data),
        -1 != data.indexOf("###ZCJSON#") && (themeParse(signupTheme),
        themeParse(thanksPageTheme))
    } else {
        var windowOpen = window.open("");
        windowOpen.document.write(data),
        windowOpen.window.history.pushState({
            html: "",
            pageTitle: ""
        }, "", "")
    }
}
function resetSignupForm(_form) {
    _form.find("input:visible").each(function() {
        var type = this.type
          , tag = this.tagName.toLowerCase();
        "text" == type || "textarea" == tag || "file" == type ? this.value = "" : ("checkbox" == type || "radio" == type) && (this.checked = !1)
    }),
    _form.find("[name='captchaContainer']").is(":visible") && loadCaptcha("", _form.find("#captchaDiv")),
    _form.unbind("submit")
}
function getCorrectSerializedData(serializedData) {
    var newparams, checkboxes = $ZC("#customForm input:checkbox:not([name='listCheckBox'])");
    checkboxes.each(function() {
        var inputname = $ZC(this).attr("name");
        if (newparams = "&" + inputname + "=" + $ZC(this).is(":checked"),
        serializedData.indexOf(inputname) > -1) {
            var serializedArrayFirstPart = serializedData.split(inputname)[0]
              , serializedArraylastPartWithOldValueRemoved = serializedData.split(inputname)[1].substring(serializedData.split(inputname)[1].indexOf("&") + 1, serializedData.split(inputname)[1].length);
            serializedData = serializedArrayFirstPart + serializedArraylastPartWithOldValueRemoved + newparams
        } else
            serializedData += newparams
    });
    var checkedRadios = $ZC("#customForm input:radio:checked");
    checkedRadios.each(function() {
        var inputname = $ZC(this).attr("name");
        radioValue = $ZC("[name='" + inputname + "']:checked").closest("label").text();
        var toberemovedtexts = $ZC("[name='" + inputname + "']:checked").closest("label").find("span").text();
        if (void 0 != radioValue && (radioValue = radioValue.replace(toberemovedtexts, ""),
        radioValue = radioValue.trim(),
        newparams = "&" + inputname + "=" + radioValue),
        serializedData.indexOf(inputname) > -1) {
            var serializedArrayFirstPart = serializedData.split(inputname)[0]
              , serializedArraylastPartWithOldValueRemoved = serializedData.split(inputname)[1].substring(serializedData.split(inputname)[1].indexOf("&") + 1, serializedData.split(inputname)[1].length);
            serializedData = serializedArrayFirstPart + serializedArraylastPartWithOldValueRemoved + newparams
        } else
            serializedData += newparams
    });
    var uncheckedRadios = $ZC("#customForm input:radio").not(":checked");
    return uncheckedRadios.each(function() {
        var inputname = $ZC(this).attr("name");
        radioValue = $ZC("[name='" + inputname + "']:checked").closest("label").text();
        var isThisChecked = $ZC("[name='" + inputname + "']:checked").length > 0;
        return isThisChecked ? !0 : void (-1 == serializedData.indexOf(inputname) && (newparams = "&" + inputname + "=" + radioValue,
        serializedData += newparams))
    }),
    serializedData
}
var imgRef = null
  , $ZC = jQuery.noConflict();
void 0 !== jQuery && ($ = jQuery);
var captchaUrl = $ZC("#zc_Url").val() + "/campaigns/CaptchaVerify.zc?mode=generate";
