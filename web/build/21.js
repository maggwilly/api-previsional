webpackJsonp([21],{

/***/ 844:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ProduitsPageModule", function() { return ProduitsPageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__produits__ = __webpack_require__(893);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



var ProduitsPageModule = /** @class */ (function () {
    function ProduitsPageModule() {
    }
    ProduitsPageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__produits__["a" /* ProduitsPage */],
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__produits__["a" /* ProduitsPage */]),
            ],
        })
    ], ProduitsPageModule);
    return ProduitsPageModule;
}());

//# sourceMappingURL=produits.module.js.map

/***/ }),

/***/ 893:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ProduitsPage; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__ionic_storage__ = __webpack_require__(88);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__providers_manager_manager__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__app_app_notify__ = __webpack_require__(482);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__providers_localisation_localisation__ = __webpack_require__(483);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};






var ProduitsPage = /** @class */ (function () {
    function ProduitsPage(navCtrl, alertCtrl, navParams, modalCtrl, manager, localisation, events, loadingCtrl, notify, storage) {
        this.navCtrl = navCtrl;
        this.alertCtrl = alertCtrl;
        this.navParams = navParams;
        this.modalCtrl = modalCtrl;
        this.manager = manager;
        this.localisation = localisation;
        this.events = events;
        this.loadingCtrl = loadingCtrl;
        this.notify = notify;
        this.storage = storage;
        this.produits = [];
        this.queryText = '';
        this.loading = false;
        this.openAddPage = this.navParams.get('openAddPage');
        this.events.subscribe('loaded:produit:new', function () {
            //  this.loadData();
        });
    }
    ProduitsPage.prototype.ionViewDidLoad = function () {
        if (this.openAddPage)
            this.add();
        this.loadData(true);
    };
    ProduitsPage.prototype.loadData = function (onlineIfEmpty) {
        var _this = this;
        this.loading = true;
        this.manager.get('produit', this.localisation.isOnline()).then(function (data) {
            _this.produits = data ? data : [];
            _this.loading = false;
            if (onlineIfEmpty && (!data || data.length))
                return _this.loadRemoteData();
        }, function (error) {
            _this.notify.onError({ message: " Verifiez votre connexion internet" });
        });
    };
    ProduitsPage.prototype.loadRemoteData = function () {
        var _this = this;
        var loader = this.notify.loading({
            content: "chargement...",
        });
        this.loading = true;
        this.manager.get('produit', this.localisation.isOnline()).then(function (data) {
            _this.produits = data ? data : [];
            _this.loading = false;
            loader.dismiss();
        }, function (error) {
            loader.dismiss();
            _this.notify.onError({ message: "Verifiez votre connexion internet" });
        });
        loader.present();
    };
    ProduitsPage.prototype.add = function (produit) {
        var _this = this;
        if (produit === void 0) { produit = {}; }
        var modal = this.modalCtrl.create('ProduitPage', { produit: produit });
        modal.onDidDismiss(function (data) {
            console.log(data);
            var index = -1;
            if (!data)
                return;
            if (data && data.deletedId || data.id) {
                index = _this.produits.findIndex(function (item) { return item.id == data.deletedId || item.id == data.id; });
                if (index > -1)
                    _this.produits.splice(index, 1);
                _this.produits.splice(0, 0, data);
            }
        });
        modal.present();
    };
    ProduitsPage.prototype.search = function () {
        var _this = this;
        var queryText = this.queryText.toLowerCase().replace(/,|\.|-/g, ' ');
        var queryWords = queryText.split(' ').filter(function (w) { return !!w.trim().length; });
        this.produits.forEach(function (item) {
            item.hide = true;
            _this.filter(item, queryWords);
        });
    };
    ProduitsPage.prototype.filter = function (item, queryWords) {
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
            // if there are no query words then this session passes the query test
            matchesQueryText = true;
        }
        item.hide = !(matchesQueryText);
    };
    ProduitsPage.prototype.doScroll = function (env) {
    };
    ProduitsPage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'page-produits',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\produits\produits.html"*/'\n<ion-header  no-border no-shadow>\n  <ion-navbar>\n      <ion-row no-padding>\n          <ion-col> <ion-title >Les produits</ion-title></ion-col>\n          <ion-col>\n            <ion-searchbar [hidden]="!produits.length"  [(ngModel)]="queryText" (ionInput)="search()" placeholder="Recherchez un produit">\n            </ion-searchbar>         \n          </ion-col>\n        </ion-row>     \n    <ion-buttons end>\n    <button ion-button="ion-button" icon-only (click)="loadRemoteData()" >\n        <ion-icon name="refresh"></ion-icon>\n    </button>\n    <button ion-button small outline (click)="add()" icon-left>\n        <ion-icon name="add" ></ion-icon>\n        Créer\n    </button>           \n</ion-buttons>    \n  </ion-navbar>\n</ion-header>\n<ion-content > \n    <ion-list *ngIf="produits.length">\n        <ion-item  *ngFor="let produit of produits" (click)="add(produit)" [hidden]="produit.hide">\n            {{produit.nom}}\n            <p>{{produit.description}}</p>\n            <ion-note item-right>{{produit.cout}}</ion-note>\n        </ion-item>\n        <div padding>\n          <button ion-button block small clear (click)="doScroll()" style="text-transform: none;">Afficher plus</button>   \n         </div>    \n    </ion-list>\n    <ion-grid style="justify-content: center; height: 100%;" *ngIf="loading">\n        <ion-row style="justify-content: center;height: 100%;" justify-content-center align-items-center>\n            <ion-spinner name="ios"></ion-spinner>\n        </ion-row>\n      </ion-grid>  \n        <ion-grid style="height: 80%;justify-content: center;position:absolute;top:20%" *ngIf="!produits.length&&!loading">\n            <ion-row style="height: 100%;justify-content: center;" justify-content-center align-items-center>\n                <div text-center text-wrap  class="empty" padding>\n                  Aucun element a afficher.\n                </div>\n            </ion-row>\n          </ion-grid>   \n</ion-content>\n<ion-footer >\n    <ion-row><ion-col>{{produits.length}} lignes</ion-col><ion-col></ion-col><ion-col></ion-col></ion-row>\n  </ion-footer>'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\produits\produits.html"*/,
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["n" /* NavController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["a" /* AlertController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["o" /* NavParams */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["l" /* ModalController */],
            __WEBPACK_IMPORTED_MODULE_3__providers_manager_manager__["a" /* ManagerProvider */],
            __WEBPACK_IMPORTED_MODULE_5__providers_localisation_localisation__["a" /* LocalisationProvider */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["d" /* Events */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["j" /* LoadingController */],
            __WEBPACK_IMPORTED_MODULE_4__app_app_notify__["a" /* AppNotify */],
            __WEBPACK_IMPORTED_MODULE_2__ionic_storage__["b" /* Storage */]])
    ], ProduitsPage);
    return ProduitsPage;
}());

//# sourceMappingURL=produits.js.map

/***/ })

});
//# sourceMappingURL=21.js.map