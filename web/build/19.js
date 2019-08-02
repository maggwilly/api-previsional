webpackJsonp([19],{

/***/ 847:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "RapportsPageModule", function() { return RapportsPageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__rapports__ = __webpack_require__(898);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



var RapportsPageModule = /** @class */ (function () {
    function RapportsPageModule() {
    }
    RapportsPageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__rapports__["a" /* RapportsPage */],
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__rapports__["a" /* RapportsPage */]),
            ],
        })
    ], RapportsPageModule);
    return RapportsPageModule;
}());

//# sourceMappingURL=rapports.module.js.map

/***/ }),

/***/ 898:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return RapportsPage; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__ionic_storage__ = __webpack_require__(88);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__providers_manager_manager__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__app_app_notify__ = __webpack_require__(482);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};





/**
 * Generated class for the RapportsPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */
var RapportsPage = /** @class */ (function () {
    function RapportsPage(navCtrl, loadingCtrl, manager, notify, storage, navParams) {
        this.navCtrl = navCtrl;
        this.loadingCtrl = loadingCtrl;
        this.manager = manager;
        this.notify = notify;
        this.storage = storage;
        this.navParams = navParams;
        this.rapports = [];
        this.queryText = '';
    }
    RapportsPage.prototype.ionViewDidLoad = function () {
        this.loadData();
    };
    RapportsPage.prototype.loadData = function () {
        var _this = this;
        this.storage.get('_rapports').then(function (data) {
            _this.rapports = data ? data : [];
            _this.manager.get('rapport').then(function (data) {
                _this.rapports = data ? data : [];
                _this.storage.set('_rapports', _this.rapports);
            }, function (error) {
                _this.notify.onError({ message: " Verifiez votre connexion internet" });
            });
        });
    };
    RapportsPage.prototype.loadRemoteData = function () {
        var _this = this;
        var loader = this.loadingCtrl.create({
            content: "chargement...",
        });
        this.manager.get('rapport').then(function (data) {
            _this.rapports = data ? data : [];
            _this.storage.set('_rapports', _this.rapports);
            loader.dismiss();
        }, function (error) {
            loader.dismiss();
            _this.notify.onError({ message: "Verifiez votre connexion internet" });
        });
        loader.present();
    };
    RapportsPage.prototype.add = function () {
        this.navCtrl.push('ProduitPage');
    };
    RapportsPage.prototype.search = function () {
        var _this = this;
        var queryText = this.queryText.toLowerCase().replace(/,|\.|-/g, ' ');
        var queryWords = queryText.split(' ').filter(function (w) { return !!w.trim().length; });
        this.rapports.forEach(function (item) {
            item.hide = true;
            _this.filter(item, queryWords);
        });
    };
    RapportsPage.prototype.filter = function (item, queryWords) {
        var matchesQueryText = false;
        if (queryWords.length) {
            // of any query word is in the session name than it passes the query test
            queryWords.forEach(function (queryWord) {
                if (item.periode.toLowerCase().indexOf(queryWord) > -1) {
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
    RapportsPage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'page-rapports',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\rapports\rapports.html"*/'<ion-header no-border no-shadow>\n    <ion-navbar>\n      <ion-title>Rapports Mensuels</ion-title>\n      <ion-buttons end>\n      <button ion-button="ion-button" icon-only (click)="loadRemoteData()" >\n          <ion-icon name="refresh"></ion-icon>\n      </button>\n  </ion-buttons>   \n    </ion-navbar>\n  </ion-header>\n  <ion-content padding>\n      <ion-searchbar [hidden]="!rapports.length" [(ngModel)]="queryText" (ionInput)="search()" placeholder="Recherchez">\n        </ion-searchbar>     \n      <ion-list>\n          <ion-item  *ngFor="let rapport of rapports" [hidden]="rapport.hide">\n              {{rapport.periode}}\n              <p>{{rapport.description}}</p>\n              <p>{{rapport.date| date:\'DD/MM/YYYY\'}}</p>\n          </ion-item>\n      </ion-list>\n  </ion-content>'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\rapports\rapports.html"*/,
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["n" /* NavController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["j" /* LoadingController */],
            __WEBPACK_IMPORTED_MODULE_3__providers_manager_manager__["a" /* ManagerProvider */],
            __WEBPACK_IMPORTED_MODULE_4__app_app_notify__["a" /* AppNotify */],
            __WEBPACK_IMPORTED_MODULE_2__ionic_storage__["b" /* Storage */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["o" /* NavParams */]])
    ], RapportsPage);
    return RapportsPage;
}());

//# sourceMappingURL=rapports.js.map

/***/ })

});
//# sourceMappingURL=19.js.map