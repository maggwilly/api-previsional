webpackJsonp([5],{

/***/ 833:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "HomePageModule", function() { return HomePageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__home__ = __webpack_require__(864);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_ionic_text_avatar__ = __webpack_require__(881);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__pipes_pipes_module__ = __webpack_require__(484);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};





var HomePageModule = /** @class */ (function () {
    function HomePageModule() {
    }
    HomePageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__home__["a" /* HomePage */],
                __WEBPACK_IMPORTED_MODULE_3_ionic_text_avatar__["a" /* IonTextAvatar */]
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__home__["a" /* HomePage */]),
                __WEBPACK_IMPORTED_MODULE_4__pipes_pipes_module__["a" /* PipesModule */]
            ],
        })
    ], HomePageModule);
    return HomePageModule;
}());

//# sourceMappingURL=home.module.js.map

/***/ }),

/***/ 864:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return HomePage; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__ionic_storage__ = __webpack_require__(88);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__providers_manager_manager__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__app_app_notify__ = __webpack_require__(482);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__providers_user_user__ = __webpack_require__(152);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__providers_localisation_localisation__ = __webpack_require__(483);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7_moment__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7_moment___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_7_moment__);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};








var HomePage = /** @class */ (function () {
    function HomePage(navCtrl, alertCtrl, modalCtrl, events, manager, localisation, userService, popoverCtrl, notify, loadingCtrl, storage) {
        this.navCtrl = navCtrl;
        this.alertCtrl = alertCtrl;
        this.modalCtrl = modalCtrl;
        this.events = events;
        this.manager = manager;
        this.localisation = localisation;
        this.userService = userService;
        this.popoverCtrl = popoverCtrl;
        this.notify = notify;
        this.loadingCtrl = loadingCtrl;
        this.storage = storage;
        this.rendezvous = [];
        this.queryText = '';
        this.events.subscribe('loaded:pointvente:new', function () {
            /*if(!this.nbrecriteres)
               this.loadData();*/
        });
    }
    HomePage.prototype.ionViewDidLoad = function () {
        var _this = this;
        this.userService.getAuthenticatedUser().subscribe(function (user) {
            if (user)
                _this.refresh();
        });
    };
    HomePage.prototype.loadData = function () {
        var _this = this;
        this.loading = true;
        this.manager.get('pointvente', this.localisation.isOnline()).then(function (data) {
            _this.rendezvous = data ? data : [];
            _this.search();
            _this.loading = false;
        }, function (error) {
            _this.notify.onSuccess({ message: "Probleme de connexion" });
        });
    };
    HomePage.prototype.loadRemoteData = function () {
        var _this = this;
        this.countCricteres(this.filtre);
        this.loading = true;
        var loader = this.loadingCtrl.create({ content: "chargement..." });
        this.manager.get('pointvente', this.localisation.isOnline(), null, null, this.filtre, this.nbrecriteres).then(function (data) {
            _this.rendezvous = data ? data : [];
            _this.search();
            _this.loading = false;
            loader.dismiss();
        }, function (error) {
            loader.dismiss();
            _this.notify.onSuccess({ message: "Probleme de connexion" });
        });
        loader.present();
    };
    HomePage.prototype.sort = function (arr) {
        if (arr.length <= 1)
            return arr;
        this.rendezvous.sort(function (a, b) {
            if ((!a.rendezvous || !a.rendezvous) || (a.rendezvous && !a.rendezvous.dateat || a.rendezvous && !a.rendezvous.dateat))
                return -1;
            return -1;
        });
    };
    HomePage.prototype.refresh = function () {
        if (!this.filtre)
            this.filtre = { type: '', user: '',
                secteur: '', ville: '',
                afterdate: __WEBPACK_IMPORTED_MODULE_7_moment__().startOf('year').format("YYYY-MM-DD"),
                //aftervisitedate:moment().startOf('month').format("YYYY-MM-DD"),
                afterrendevousdate: __WEBPACK_IMPORTED_MODULE_7_moment__().startOf('year').format("YYYY-MM-DD"),
                beforedate: __WEBPACK_IMPORTED_MODULE_7_moment__().format("YYYY-MM-DD"),
                beforevisitedate: __WEBPACK_IMPORTED_MODULE_7_moment__().endOf('week').format("YYYY-MM-DD"),
                beforrendezvousdate: __WEBPACK_IMPORTED_MODULE_7_moment__().endOf('month').format("YYYY-MM-DD")
            };
        this.nbrecriteres = 0;
        this.queryText = '';
        if (this.localisation.isOnline())
            return this.loadRemoteData();
        this.loadData();
    };
    HomePage.prototype.openFilter = function () {
        var _this = this;
        var modal = this.modalCtrl.create('FiltrePointventePage', { filtre: this.filtre });
        modal.onDidDismiss(function (data) {
            if (!data)
                return;
            _this.countCricteres(_this.filtre);
            return _this.loadRemoteData();
        });
        modal.present();
    };
    HomePage.prototype.doScroll = function (env) {
    };
    HomePage.prototype.countCricteres = function (data) {
        var nbrecriteres = 0;
        Object.keys(data).forEach(function (key) {
            if (data[key])
                nbrecriteres++;
        });
        this.nbrecriteres = nbrecriteres;
    };
    HomePage.prototype.show = function (pointVente) {
        this.navCtrl.push('PointVenteDetailPage', { pointVente: pointVente });
    };
    HomePage.prototype.search = function () {
        var _this = this;
        var queryText = this.queryText.toLowerCase().replace(/,|\.|-/g, ' ');
        var queryWords = queryText.split(' ').filter(function (w) { return !!w.trim().length; });
        this.rendezvous.forEach(function (item) {
            item.hide = true;
            _this.filter(item, queryWords);
        });
    };
    HomePage.prototype.filter = function (item, queryWords) {
        var matchesQueryText = false;
        if (queryWords.length) {
            // of any query word is in the session name than it passes the query test
            queryWords.forEach(function (queryWord) {
                if (item.nom.toLowerCase().indexOf(queryWord) > -1) {
                    matchesQueryText = true;
                }
            });
        }
        else {
            matchesQueryText = true;
        }
        item.hide = !(matchesQueryText);
    };
    HomePage.prototype.presentPopover = function (ev) {
        var popover = this.popoverCtrl.create('PopOverMenuPage', { navCtrl: this.navCtrl });
        popover.present({
            ev: ev
        });
    };
    HomePage.prototype.openMap = function () {
        var points = [];
        this.rendezvous.forEach(function (point) {
            if (point.lat && point.long) {
                points.push({ pos: { lat: point.lat, long: point.long },
                    title: point.nom,
                    address: point.adresse,
                    type: point.type,
                    quartier: point.quartier,
                    visited: point.lastCommende,
                });
            }
        });
        this.navCtrl.push('MapPage', { points: points, title: "Aper\u00E7u des r\u00E9alit\u00E9s", filtre: this.filtre });
    };
    HomePage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'page-home',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\home\home.html"*/'<ion-header >\n  <ion-navbar>\n    <button menuToggle  ion-button icon-only>\n      <ion-icon name="menu"></ion-icon>\n    </button>\n    <ion-row no-padding>\n        <ion-col ><ion-title>Accueil</ion-title></ion-col>\n        <ion-col>\n          <ion-searchbar *ngIf="rendezvous" [hidden]="!rendezvous.length" [(ngModel)]="queryText" (ionInput)="search()" placeholder="Recherchez un nom">\n          </ion-searchbar>         \n        </ion-col>\n      </ion-row>    \n    <ion-buttons end>\n      <button ion-button icon-only (click)="refresh()">\n        <ion-icon name="refresh"></ion-icon>\n      </button>\n      <button ion-button icon-only (click)="presentPopover($event)">\n          <ion-icon name="more"></ion-icon>\n        </button>       \n    </ion-buttons>\n  </ion-navbar>\n</ion-header>\n<ion-content>\n    <ion-row justify-content-around>\n        <ion-col col-6 >\n         <button ion-button icon-left outline small (click)="openFilter()"><ion-icon name="funnel"></ion-icon> \n          Critères  \n          <span *ngIf="nbrecriteres"> - ({{nbrecriteres}})</span></button>\n        </ion-col>\n        <ion-col col-6 class="item-right">\n         <button float-right ion-button icon-left outline small (click)="openMap()" [disabled]="!rendezvous.length"> <ion-icon name="map"></ion-icon>Carte</button>\n       </ion-col>   \n      </ion-row>\n   <ion-list *ngIf="rendezvous.length">\n    <ion-item #item *ngFor="let pointvente of rendezvous" (click)="show(pointvente)" [hidden]="pointvente.hide||!pointvente.nom" text-wrap>\n      {{pointvente.nom}} - <strong>{{pointvente.type}}</strong>\n      <p><span>{{pointvente.telephone}}</span><span *ngIf="pointvente.ville">, {{pointvente.ville}}</span>\n        <span *ngIf="pointvente.quartier">, {{pointvente.quartier}}</span><span *ngIf="pointvente.adresse">, {{pointvente.adresse}}</span>\n         - <small *ngIf="pointvente.firstCommende">Engagé {{pointvente.firstCommende.date|moment:\'fromnow\'}}</small>\n        <small *ngIf="!pointvente.firstCommende">Prospecté {{pointvente.date|moment:\'fromnow\'}}</small>\n      </p>\n      <p  *ngIf="pointvente.rendezvous&&pointvente.rendezvous.dateat">\n          <span class="success"> Prochaine livraison {{pointvente.rendezvous.dateat |moment}}</span> <ion-icon *ngIf="pointvente.rendezvous.persist" name="md-checkmark-circle"></ion-icon>\n      </p>\n      <p *ngIf="pointvente.rendezvous&&!pointvente.rendezvous.dateat">\n          <span  *ngIf="pointvente.rendezvous.produitnonvendu&&pointvente.lastCommende"> Dernier livraison {{pointvente.lastCommende.date |moment}}, <span class="danger">{{pointvente.rendezvous.produitnonvendu}} produit(S) non livrés (s)</span> </span>\n          <span   *ngIf="!pointvente.rendezvous.produitnonvendu&&pointvente.lastCommende"> Dernier passage {{pointvente.lastCommende.date |moment}} </span>\n          <span  class="danger" *ngIf="!pointvente.lastCommende">Pas encore engagé</span>\n      </p>       \n      <ion-badge  item-right *ngIf="pointvente.rendezvous&&pointvente.rendezvous.dateat">\n          <span  > {{pointvente.rendezvous.dateat |moment}}</span>\n      </ion-badge>    \n \n  </ion-item>    \n    <div padding>\n      <button ion-button block small clear (click)="refresh()" style="text-transform: none;">Afficher plus</button>   \n     </div>  \n  </ion-list>\n  <ion-grid style="height: 80%;justify-content: center;position:absolute;top:20%" *ngIf="!rendezvous.length&&!loading">\n    <ion-row style="height: 100%;justify-content: center;" justify-content-center align-items-center>\n        <div text-center text-wrap  class="empty" padding>\n          Aucun element correspondant aux critères.\n        </div>\n    </ion-row>\n  </ion-grid>\n</ion-content>\n<ion-footer >\n  <ion-row><ion-col>{{rendezvous.length}} lignes</ion-col><ion-col></ion-col><ion-col></ion-col></ion-row>\n</ion-footer>'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\home\home.html"*/
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["n" /* NavController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["a" /* AlertController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["l" /* ModalController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["d" /* Events */],
            __WEBPACK_IMPORTED_MODULE_3__providers_manager_manager__["a" /* ManagerProvider */],
            __WEBPACK_IMPORTED_MODULE_6__providers_localisation_localisation__["a" /* LocalisationProvider */],
            __WEBPACK_IMPORTED_MODULE_5__providers_user_user__["a" /* UserProvider */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["q" /* PopoverController */],
            __WEBPACK_IMPORTED_MODULE_4__app_app_notify__["a" /* AppNotify */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["j" /* LoadingController */],
            __WEBPACK_IMPORTED_MODULE_2__ionic_storage__["b" /* Storage */]])
    ], HomePage);
    return HomePage;
}());

//# sourceMappingURL=home.js.map

/***/ }),

/***/ 881:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__src_ion_text_avatar_ion_text_avatar__ = __webpack_require__(882);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return __WEBPACK_IMPORTED_MODULE_0__src_ion_text_avatar_ion_text_avatar__["a"]; });

//# sourceMappingURL=index.js.map

/***/ }),

/***/ 882:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return IonTextAvatar; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
        function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};


var IonTextAvatar = (function (_super) {
    __extends(IonTextAvatar, _super);
    function IonTextAvatar(config, elementRef, renderer) {
        return _super.call(this, config, elementRef, renderer, 'ion-text-avatar') || this;
    }
    IonTextAvatar = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"])({
            selector: 'ion-text-avatar',
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["c" /* Config */], __WEBPACK_IMPORTED_MODULE_0__angular_core__["ElementRef"], __WEBPACK_IMPORTED_MODULE_0__angular_core__["Renderer"]])
    ], IonTextAvatar);
    return IonTextAvatar;
}(__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["e" /* Ion */]));

//# sourceMappingURL=ion-text-avatar.js.map

/***/ })

});
//# sourceMappingURL=5.js.map