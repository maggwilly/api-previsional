webpackJsonp([4],{

/***/ 855:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "SignupPageModule", function() { return SignupPageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__signup__ = __webpack_require__(906);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_angular2_text_mask__ = __webpack_require__(907);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_angular2_text_mask___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3_angular2_text_mask__);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};




var SignupPageModule = /** @class */ (function () {
    function SignupPageModule() {
    }
    SignupPageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__signup__["a" /* SignupPage */],
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__signup__["a" /* SignupPage */]),
                __WEBPACK_IMPORTED_MODULE_3_angular2_text_mask__["TextMaskModule"]
            ],
        })
    ], SignupPageModule);
    return SignupPageModule;
}());

//# sourceMappingURL=signup.module.js.map

/***/ }),

/***/ 866:
/***/ (function(module, exports, __webpack_require__) {

!function(e,r){ true?module.exports=r():"function"==typeof define&&define.amd?define([],r):"object"==typeof exports?exports.textMaskCore=r():e.textMaskCore=r()}(this,function(){return function(e){function r(n){if(t[n])return t[n].exports;var o=t[n]={exports:{},id:n,loaded:!1};return e[n].call(o.exports,o,o.exports,r),o.loaded=!0,o.exports}var t={};return r.m=e,r.c=t,r.p="",r(0)}([function(e,r,t){"use strict";function n(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(r,"__esModule",{value:!0});var o=t(3);Object.defineProperty(r,"conformToMask",{enumerable:!0,get:function(){return n(o).default}});var i=t(2);Object.defineProperty(r,"adjustCaretPosition",{enumerable:!0,get:function(){return n(i).default}});var a=t(5);Object.defineProperty(r,"createTextMaskInputElement",{enumerable:!0,get:function(){return n(a).default}})},function(e,r){"use strict";Object.defineProperty(r,"__esModule",{value:!0}),r.placeholderChar="_",r.strFunction="function"},function(e,r){"use strict";function t(e){var r=e.previousConformedValue,t=void 0===r?o:r,i=e.previousPlaceholder,a=void 0===i?o:i,u=e.currentCaretPosition,l=void 0===u?0:u,s=e.conformedValue,f=e.rawValue,d=e.placeholderChar,c=e.placeholder,p=e.indexesOfPipedChars,v=void 0===p?n:p,h=e.caretTrapIndexes,m=void 0===h?n:h;if(0===l||!f.length)return 0;var y=f.length,g=t.length,b=c.length,C=s.length,P=y-g,k=P>0,x=0===g,O=P>1&&!k&&!x;if(O)return l;var T=k&&(t===s||s===c),w=0,M=void 0,S=void 0;if(T)w=l-P;else{var j=s.toLowerCase(),_=f.toLowerCase(),V=_.substr(0,l).split(o),A=V.filter(function(e){return j.indexOf(e)!==-1});S=A[A.length-1];var N=a.substr(0,A.length).split(o).filter(function(e){return e!==d}).length,E=c.substr(0,A.length).split(o).filter(function(e){return e!==d}).length,F=E!==N,R=void 0!==a[A.length-1]&&void 0!==c[A.length-2]&&a[A.length-1]!==d&&a[A.length-1]!==c[A.length-1]&&a[A.length-1]===c[A.length-2];!k&&(F||R)&&N>0&&c.indexOf(S)>-1&&void 0!==f[l]&&(M=!0,S=f[l]);for(var I=v.map(function(e){return j[e]}),J=I.filter(function(e){return e===S}).length,W=A.filter(function(e){return e===S}).length,q=c.substr(0,c.indexOf(d)).split(o).filter(function(e,r){return e===S&&f[r]!==e}).length,L=q+W+J+(M?1:0),z=0,B=0;B<C;B++){var D=j[B];if(w=B+1,D===S&&z++,z>=L)break}}if(k){for(var G=w,H=w;H<=b;H++)if(c[H]===d&&(G=H),c[H]===d||m.indexOf(H)!==-1||H===b)return G}else if(M){for(var K=w-1;K>=0;K--)if(s[K]===S||m.indexOf(K)!==-1||0===K)return K}else for(var Q=w;Q>=0;Q--)if(c[Q-1]===d||m.indexOf(Q)!==-1||0===Q)return Q}Object.defineProperty(r,"__esModule",{value:!0}),r.default=t;var n=[],o=""},function(e,r,t){"use strict";function n(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:l,r=arguments.length>1&&void 0!==arguments[1]?arguments[1]:u,t=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};if(!(0,i.isArray)(r)){if(("undefined"==typeof r?"undefined":o(r))!==a.strFunction)throw new Error("Text-mask:conformToMask; The mask property must be an array.");r=r(e,t),r=(0,i.processCaretTraps)(r).maskWithoutCaretTraps}var n=t.guide,s=void 0===n||n,f=t.previousConformedValue,d=void 0===f?l:f,c=t.placeholderChar,p=void 0===c?a.placeholderChar:c,v=t.placeholder,h=void 0===v?(0,i.convertMaskToPlaceholder)(r,p):v,m=t.currentCaretPosition,y=t.keepCharPositions,g=s===!1&&void 0!==d,b=e.length,C=d.length,P=h.length,k=r.length,x=b-C,O=x>0,T=m+(O?-x:0),w=T+Math.abs(x);if(y===!0&&!O){for(var M=l,S=T;S<w;S++)h[S]===p&&(M+=p);e=e.slice(0,T)+M+e.slice(T,b)}for(var j=e.split(l).map(function(e,r){return{char:e,isNew:r>=T&&r<w}}),_=b-1;_>=0;_--){var V=j[_].char;if(V!==p){var A=_>=T&&C===k;V===h[A?_-x:_]&&j.splice(_,1)}}var N=l,E=!1;e:for(var F=0;F<P;F++){var R=h[F];if(R===p){if(j.length>0)for(;j.length>0;){var I=j.shift(),J=I.char,W=I.isNew;if(J===p&&g!==!0){N+=p;continue e}if(r[F].test(J)){if(y===!0&&W!==!1&&d!==l&&s!==!1&&O){for(var q=j.length,L=null,z=0;z<q;z++){var B=j[z];if(B.char!==p&&B.isNew===!1)break;if(B.char===p){L=z;break}}null!==L?(N+=J,j.splice(L,1)):F--}else N+=J;continue e}E=!0}g===!1&&(N+=h.substr(F,P));break}N+=R}if(g&&O===!1){for(var D=null,G=0;G<N.length;G++)h[G]===p&&(D=G);N=null!==D?N.substr(0,D+1):l}return{conformedValue:N,meta:{someCharsRejected:E}}}Object.defineProperty(r,"__esModule",{value:!0});var o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e};r.default=n;var i=t(4),a=t(1),u=[],l=""},function(e,r,t){"use strict";function n(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:f,r=arguments.length>1&&void 0!==arguments[1]?arguments[1]:s.placeholderChar;if(!o(e))throw new Error("Text-mask:convertMaskToPlaceholder; The mask property must be an array.");if(e.indexOf(r)!==-1)throw new Error("Placeholder character must not be used as part of the mask. Please specify a character that is not present in your mask as your placeholder character.\n\n"+("The placeholder character that was received is: "+JSON.stringify(r)+"\n\n")+("The mask that was received is: "+JSON.stringify(e)));return e.map(function(e){return e instanceof RegExp?r:e}).join("")}function o(e){return Array.isArray&&Array.isArray(e)||e instanceof Array}function i(e){return"string"==typeof e||e instanceof String}function a(e){return"number"==typeof e&&void 0===e.length&&!isNaN(e)}function u(e){return"undefined"==typeof e||null===e}function l(e){for(var r=[],t=void 0;t=e.indexOf(d),t!==-1;)r.push(t),e.splice(t,1);return{maskWithoutCaretTraps:e,indexes:r}}Object.defineProperty(r,"__esModule",{value:!0}),r.convertMaskToPlaceholder=n,r.isArray=o,r.isString=i,r.isNumber=a,r.isNil=u,r.processCaretTraps=l;var s=t(1),f=[],d="[]"},function(e,r,t){"use strict";function n(e){return e&&e.__esModule?e:{default:e}}function o(e){var r={previousConformedValue:void 0,previousPlaceholder:void 0};return{state:r,update:function(t){var n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:e,o=n.inputElement,s=n.mask,d=n.guide,m=n.pipe,g=n.placeholderChar,b=void 0===g?v.placeholderChar:g,C=n.keepCharPositions,P=void 0!==C&&C,k=n.showMask,x=void 0!==k&&k;if("undefined"==typeof t&&(t=o.value),t!==r.previousConformedValue){("undefined"==typeof s?"undefined":l(s))===y&&void 0!==s.pipe&&void 0!==s.mask&&(m=s.pipe,s=s.mask);var O=void 0,T=void 0;if(s instanceof Array&&(O=(0,p.convertMaskToPlaceholder)(s,b)),s!==!1){var w=a(t),M=o.selectionEnd,S=r.previousConformedValue,j=r.previousPlaceholder,_=void 0;if(("undefined"==typeof s?"undefined":l(s))===v.strFunction){if(T=s(w,{currentCaretPosition:M,previousConformedValue:S,placeholderChar:b}),T===!1)return;var V=(0,p.processCaretTraps)(T),A=V.maskWithoutCaretTraps,N=V.indexes;T=A,_=N,O=(0,p.convertMaskToPlaceholder)(T,b)}else T=s;var E={previousConformedValue:S,guide:d,placeholderChar:b,pipe:m,placeholder:O,currentCaretPosition:M,keepCharPositions:P},F=(0,c.default)(w,T,E),R=F.conformedValue,I=("undefined"==typeof m?"undefined":l(m))===v.strFunction,J={};I&&(J=m(R,u({rawValue:w},E)),J===!1?J={value:S,rejected:!0}:(0,p.isString)(J)&&(J={value:J}));var W=I?J.value:R,q=(0,f.default)({previousConformedValue:S,previousPlaceholder:j,conformedValue:W,placeholder:O,rawValue:w,currentCaretPosition:M,placeholderChar:b,indexesOfPipedChars:J.indexesOfPipedChars,caretTrapIndexes:_}),L=W===O&&0===q,z=x?O:h,B=L?z:W;r.previousConformedValue=B,r.previousPlaceholder=O,o.value!==B&&(o.value=B,i(o,q))}}}}}function i(e,r){document.activeElement===e&&(g?b(function(){return e.setSelectionRange(r,r,m)},0):e.setSelectionRange(r,r,m))}function a(e){if((0,p.isString)(e))return e;if((0,p.isNumber)(e))return String(e);if(void 0===e||null===e)return h;throw new Error("The 'value' provided to Text Mask needs to be a string or a number. The value received was:\n\n "+JSON.stringify(e))}Object.defineProperty(r,"__esModule",{value:!0});var u=Object.assign||function(e){for(var r=1;r<arguments.length;r++){var t=arguments[r];for(var n in t)Object.prototype.hasOwnProperty.call(t,n)&&(e[n]=t[n])}return e},l="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e};r.default=o;var s=t(2),f=n(s),d=t(3),c=n(d),p=t(4),v=t(1),h="",m="none",y="object",g="undefined"!=typeof navigator&&/Android/i.test(navigator.userAgent),b="undefined"!=typeof requestAnimationFrame?requestAnimationFrame:setTimeout}])});

/***/ }),

/***/ 906:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return SignupPage; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__app_app_notify__ = __webpack_require__(482);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__providers_manager_manager__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__angular_forms__ = __webpack_require__(26);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};





var SignupPage = /** @class */ (function () {
    function SignupPage(navCtrl, alertCtrl, loadingCtrl, formBuilder, manager, appNotify) {
        this.navCtrl = navCtrl;
        this.alertCtrl = alertCtrl;
        this.loadingCtrl = loadingCtrl;
        this.formBuilder = formBuilder;
        this.manager = manager;
        this.appNotify = appNotify;
        this.submitted = false;
        this.stape = 'phone';
        this.data = {};
        this.phone = new __WEBPACK_IMPORTED_MODULE_4__angular_forms__["FormControl"]('', __WEBPACK_IMPORTED_MODULE_4__angular_forms__["Validators"].compose([
            __WEBPACK_IMPORTED_MODULE_4__angular_forms__["Validators"].required,
            __WEBPACK_IMPORTED_MODULE_4__angular_forms__["Validators"].pattern("[5-9]{1}[0-9]{8}")
        ]));
        this.phone2 = new __WEBPACK_IMPORTED_MODULE_4__angular_forms__["FormControl"]('', __WEBPACK_IMPORTED_MODULE_4__angular_forms__["Validators"].compose([
            __WEBPACK_IMPORTED_MODULE_4__angular_forms__["Validators"].required,
            __WEBPACK_IMPORTED_MODULE_4__angular_forms__["Validators"].pattern("[5-9]{1}[0-9]{8}")
        ]));
        this.code = new __WEBPACK_IMPORTED_MODULE_4__angular_forms__["FormControl"]('', __WEBPACK_IMPORTED_MODULE_4__angular_forms__["Validators"].compose([
            __WEBPACK_IMPORTED_MODULE_4__angular_forms__["Validators"].required,
            __WEBPACK_IMPORTED_MODULE_4__angular_forms__["Validators"].minLength(6)
        ]));
        this.nom = new __WEBPACK_IMPORTED_MODULE_4__angular_forms__["FormControl"]('', __WEBPACK_IMPORTED_MODULE_4__angular_forms__["Validators"].compose([
            __WEBPACK_IMPORTED_MODULE_4__angular_forms__["Validators"].required
        ]));
        // @todo add better email-validation pattern...
        this.email = new __WEBPACK_IMPORTED_MODULE_4__angular_forms__["FormControl"]('', __WEBPACK_IMPORTED_MODULE_4__angular_forms__["Validators"].compose([
            __WEBPACK_IMPORTED_MODULE_4__angular_forms__["Validators"].required,
            __WEBPACK_IMPORTED_MODULE_4__angular_forms__["Validators"].pattern("^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"),
        ]));
        this.plainPassword = new __WEBPACK_IMPORTED_MODULE_4__angular_forms__["FormControl"]('', __WEBPACK_IMPORTED_MODULE_4__angular_forms__["Validators"].compose([
            __WEBPACK_IMPORTED_MODULE_4__angular_forms__["Validators"].required,
            __WEBPACK_IMPORTED_MODULE_4__angular_forms__["Validators"].minLength(4),
            __WEBPACK_IMPORTED_MODULE_4__angular_forms__["Validators"].maxLength(24)
        ]));
        this.passwordConfirm = new __WEBPACK_IMPORTED_MODULE_4__angular_forms__["FormControl"]('', __WEBPACK_IMPORTED_MODULE_4__angular_forms__["Validators"].compose([
            __WEBPACK_IMPORTED_MODULE_4__angular_forms__["Validators"].required,
            __WEBPACK_IMPORTED_MODULE_4__angular_forms__["Validators"].minLength(6),
            __WEBPACK_IMPORTED_MODULE_4__angular_forms__["Validators"].maxLength(24),
        ]));
        this.formPhone = this.formBuilder.group({
            login: this.phone,
        });
        this.newUser = this.formBuilder.group({
            username: this.phone2,
            email: this.email,
            nom: this.nom
        });
        this.formCode = this.formBuilder.group({
            value: this.code,
        });
    }
    SignupPage.prototype.ionViewDidLoad = function () {
        console.log('Hello Signup Page');
    };
    SignupPage.prototype.onSubmit = function () {
        var _this = this;
        this.submitted = true;
        this.manager.post('register', this.newUser.value, 'new', true).then(function (data) {
            _this.submitted = false;
            _this.data = data;
            console.log(data);
            if (data.value)
                _this.stape = 'code';
        }, function (error) {
            _this.submitted = false;
            console.log(error);
            _this.appNotify.showAlert({ message: 'Le service peut-etre  indisponible. Verifiez votre connexion internet' });
        });
    };
    SignupPage.prototype.nextStape = function () {
        var _this = this;
        switch (this.stape) {
            case 'phone':
                this.submitted = true;
                this.manager.post('token', this.formPhone.value, 'new', true).then(function (data) {
                    _this.submitted = false;
                    console.log(data);
                    _this.data = data;
                    if (data.value)
                        _this.stape = 'code';
                    else if (data.create) {
                        _this.stape = 'user';
                        _this.phone2.setValue(data.create.login);
                    }
                }, function (error) {
                    console.log(error);
                    _this.submitted = false;
                    _this.appNotify.showAlert({ message: 'Le service peut-etre  indisponible. Verifiez votre connexion internet' });
                });
                break;
            case 'code':
                this.submitted = true;
                var code = this.formCode.value;
                code.user = this.data.user.id;
                this.manager.post('token', code, 'check', true).then(function (data) {
                    _this.submitted = false;
                    if (data.error_code) {
                        _this.appNotify.showAlert({ message: data.message });
                        return;
                    }
                    _this.manager.storeUser(data).then(function () {
                        _this.navCtrl.setRoot('MenuPage', {}, { animate: true, direction: 'forward' });
                    }, function (error) {
                        console.log(error);
                        _this.submitted = false;
                        _this.appNotify.showAlert({ message: 'Le service peut-etre  indisponible. Verifiez votre connexion internet' });
                    });
                }, function (error) {
                    console.log(error);
                    _this.submitted = false;
                    _this.appNotify.showAlert({ message: 'Le service peut-etre  indisponible. Verifiez votre connexion internet' });
                });
                break;
            default:
                break;
        }
    };
    SignupPage.prototype.previewStape = function () {
        switch (this.stape) {
            case 'user':
            case 'code':
                this.stape = 'phone';
                break;
            default:
                break;
        }
    };
    SignupPage.prototype.isInvalid = function () {
        switch (this.stape) {
            case 'phone':
                return !this.formPhone.valid;
            case 'user':
                return !this.newUser.valid;
            case 'code':
                return !this.formCode.valid;
        }
    };
    SignupPage.prototype.login = function () {
        this.navCtrl.push('LoginPage');
    };
    SignupPage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'page-signup',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\signup\signup.html"*/'<ion-content center center-center class="transparent-header bgAuth" horizontal layout padding>\n    <ion-header>\n        <ion-navbar></ion-navbar>\n    </ion-header>\n    <ion-grid>\n        <ion-row justify-content-center>\n       <ion-col col-sm-12  col-md-6 col-lg-4 col-xl-3>  \n    <section *ngIf="stape==\'phone\'">\n        <form [formGroup]="formPhone">\n            <div padding text-center>\n                <strong>NUMERO DE TELEPHONE</strong>\n                <p>Saisir votre numéro de télephone pour vous connecter à votre compte.</p>\n            </div>\n            <div padding>\n                <ion-item>\n                    <ion-input formControlName="login" placeholder="Numéro de télephone" type="tel"></ion-input>\n                </ion-item>\n                <div *ngIf="!phone.valid&&phone.touched">\n                    <small *ngIf="phone.errors&&phone.dirty" color="danger">Saisir un numéro de telephone valide de 09 chiffres.</small>\n                </div>\n                <button (click)="nextStape()"   [disabled]="submitted||isInvalid()" block class="login-button" color="secondary" ion-button outline>\n                    <span>\n                        <strong>Suivant</strong>\n                    </span>\n                </button>\n            </div>\n        </form>\n    </section>\n    <section *ngIf="stape==\'code\'">\n        <form [formGroup]="formCode">\n            <div padding text-center>\n                <strong>CODE DE VERIFICATION</strong>\n                <p>Saisir le code de vérification qui vous a été envoyé par SMS.</p>\n            </div>\n            <div padding>\n                <ion-item>\n                    <ion-input formControlName="value" placeholder="Code de vérification" type="tel"></ion-input>\n                </ion-item>\n                <button (click)="nextStape()"  [disabled]="submitted||isInvalid()" block class="login-button" color="danger" ion-button >\n                    <span>\n                        <ion-icon name="done"></ion-icon>\n                        <strong>Terminer</strong>\n                    </span>\n                </button>\n            </div>\n        </form>\n    </section>\n    <section *ngIf="stape==\'user\'">\n        <form [formGroup]="newUser">\n            <div text-center padding-left padding-right>\n                <strong>INFORMATIONS PERSONNELLES</strong>\n                <p>Saisir les informations de base sur votre entreprise.</p>\n            </div>\n            <div padding>\n                <ion-item>\n                    <ion-input formControlName="nom" placeholder="Votre nom" type="text"></ion-input>\n                </ion-item>\n                <ion-item>\n                    <ion-input formControlName="username" placeholder="Numéro de télephone" type="tel" disabled="true"></ion-input>\n                </ion-item>\n                <div *ngIf="!phone2.valid&&phone2.touched">\n                    <small *ngIf="phone2.errors&&phone2.dirty" color="danger">Saisir un numéro de telephone valide de 09 chiffres.</small>\n                </div>                              \n                <ion-item>\n                    <ion-input formControlName="email" placeholder="Adresse mail" type="text"></ion-input>\n                </ion-item>\n                <div *ngIf="!email.valid && email.touched">\n                    <div><small *ngIf="email.errors&& email.dirty">Saisir une adresse mail valide.</small></div>\n                </div>                                \n                <button (click)="onSubmit()"   [disabled]="submitted||isInvalid()" block color="secondary" icon-left ion-button>\n                    <span >\n                        <ion-icon name="log-in"></ion-icon>\n                        <strong>Terminer</strong>\n                    </span>\n                </button>\n            </div>\n        </form>\n    </section>\n    <div class="spiner" horizontal layout center center-center padding [hidden]="!submitted">\n        <ion-grid>\n         <ion-row justify-content-center align-items-center>    \n       <ion-spinner color="white" name="ios"></ion-spinner>\n      </ion-row>    \n   </ion-grid> \n    </div>\n</ion-col>\n</ion-row>\n</ion-grid>   \n</ion-content>\n<ion-footer no-border no-shadow>\n<button ion-item (click)="previewStape()" *ngIf="stape!=\'phone\'" text-wrap class="goback">\n    <a>\n        <strong>Retourner</strong>\n    </a>\n    à la section précedente.\n</button>\n</ion-footer>'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\signup\signup.html"*/,
            providers: [__WEBPACK_IMPORTED_MODULE_2__app_app_notify__["a" /* AppNotify */]]
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["n" /* NavController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["a" /* AlertController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["j" /* LoadingController */],
            __WEBPACK_IMPORTED_MODULE_4__angular_forms__["FormBuilder"],
            __WEBPACK_IMPORTED_MODULE_3__providers_manager_manager__["a" /* ManagerProvider */],
            __WEBPACK_IMPORTED_MODULE_2__app_app_notify__["a" /* AppNotify */]])
    ], SignupPage);
    return SignupPage;
}());

//# sourceMappingURL=signup.js.map

/***/ }),

/***/ 907:
/***/ (function(module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__(1);
var forms_1 = __webpack_require__(26);
var platform_browser_1 = __webpack_require__(39);
var textMaskCore_1 = __webpack_require__(866);
var TextMaskConfig = /** @class */ (function () {
    function TextMaskConfig() {
    }
    return TextMaskConfig;
}());
exports.TextMaskConfig = TextMaskConfig;
exports.MASKEDINPUT_VALUE_ACCESSOR = {
    provide: forms_1.NG_VALUE_ACCESSOR,
    useExisting: core_1.forwardRef(function () { return MaskedInputDirective; }),
    multi: true
};
/**
 * We must check whether the agent is Android because composition events
 * behave differently between iOS and Android.
 */
function _isAndroid() {
    var userAgent = platform_browser_1.ɵgetDOM() ? platform_browser_1.ɵgetDOM().getUserAgent() : '';
    return /android (\d+)/.test(userAgent.toLowerCase());
}
var MaskedInputDirective = /** @class */ (function () {
    function MaskedInputDirective(_renderer, _elementRef, _compositionMode) {
        this._renderer = _renderer;
        this._elementRef = _elementRef;
        this._compositionMode = _compositionMode;
        this.textMaskConfig = {
            mask: [],
            guide: true,
            placeholderChar: '_',
            pipe: undefined,
            keepCharPositions: false,
        };
        this.onChange = function (_) { };
        this.onTouched = function () { };
        /** Whether the user is creating a composition string (IME events). */
        this._composing = false;
        if (this._compositionMode == null) {
            this._compositionMode = !_isAndroid();
        }
    }
    MaskedInputDirective.prototype.ngOnChanges = function (changes) {
        this._setupMask(true);
        if (this.textMaskInputElement !== undefined) {
            this.textMaskInputElement.update(this.inputElement.value);
        }
    };
    MaskedInputDirective.prototype.writeValue = function (value) {
        this._setupMask();
        // set the initial value for cases where the mask is disabled
        var normalizedValue = value == null ? '' : value;
        this._renderer.setProperty(this.inputElement, 'value', normalizedValue);
        if (this.textMaskInputElement !== undefined) {
            this.textMaskInputElement.update(value);
        }
    };
    MaskedInputDirective.prototype.registerOnChange = function (fn) { this.onChange = fn; };
    MaskedInputDirective.prototype.registerOnTouched = function (fn) { this.onTouched = fn; };
    MaskedInputDirective.prototype.setDisabledState = function (isDisabled) {
        this._renderer.setProperty(this._elementRef.nativeElement, 'disabled', isDisabled);
    };
    MaskedInputDirective.prototype._handleInput = function (value) {
        if (!this._compositionMode || (this._compositionMode && !this._composing)) {
            this._setupMask();
            if (this.textMaskInputElement !== undefined) {
                this.textMaskInputElement.update(value);
                // get the updated value
                value = this.inputElement.value;
                this.onChange(value);
            }
        }
    };
    MaskedInputDirective.prototype._setupMask = function (create) {
        if (create === void 0) { create = false; }
        if (!this.inputElement) {
            if (this._elementRef.nativeElement.tagName.toUpperCase() === 'INPUT') {
                // `textMask` directive is used directly on an input element
                this.inputElement = this._elementRef.nativeElement;
            }
            else {
                // `textMask` directive is used on an abstracted input element, `md-input-container`, etc
                this.inputElement = this._elementRef.nativeElement.getElementsByTagName('INPUT')[0];
            }
        }
        if (this.inputElement && create) {
            this.textMaskInputElement = textMaskCore_1.createTextMaskInputElement(Object.assign({ inputElement: this.inputElement }, this.textMaskConfig));
        }
    };
    MaskedInputDirective.prototype._compositionStart = function () { this._composing = true; };
    MaskedInputDirective.prototype._compositionEnd = function (value) {
        this._composing = false;
        this._compositionMode && this._handleInput(value);
    };
    MaskedInputDirective.decorators = [
        { type: core_1.Directive, args: [{
                    host: {
                        '(input)': '_handleInput($event.target.value)',
                        '(blur)': 'onTouched()',
                        '(compositionstart)': '_compositionStart()',
                        '(compositionend)': '_compositionEnd($event.target.value)'
                    },
                    selector: '[textMask]',
                    exportAs: 'textMask',
                    providers: [exports.MASKEDINPUT_VALUE_ACCESSOR]
                },] },
    ];
    /** @nocollapse */
    MaskedInputDirective.ctorParameters = function () { return [
        { type: core_1.Renderer2, },
        { type: core_1.ElementRef, },
        { type: undefined, decorators: [{ type: core_1.Optional }, { type: core_1.Inject, args: [forms_1.COMPOSITION_BUFFER_MODE,] },] },
    ]; };
    MaskedInputDirective.propDecorators = {
        'textMaskConfig': [{ type: core_1.Input, args: ['textMask',] },],
    };
    return MaskedInputDirective;
}());
exports.MaskedInputDirective = MaskedInputDirective;
var TextMaskModule = /** @class */ (function () {
    function TextMaskModule() {
    }
    TextMaskModule.decorators = [
        { type: core_1.NgModule, args: [{
                    declarations: [MaskedInputDirective],
                    exports: [MaskedInputDirective]
                },] },
    ];
    /** @nocollapse */
    TextMaskModule.ctorParameters = function () { return []; };
    return TextMaskModule;
}());
exports.TextMaskModule = TextMaskModule;
var textMaskCore_2 = __webpack_require__(866);
exports.conformToMask = textMaskCore_2.conformToMask;
//# sourceMappingURL=angular2TextMask.js.map

/***/ })

});
//# sourceMappingURL=4.js.map