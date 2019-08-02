webpackJsonp([25],{

/***/ 840:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "PrevisionsPageModule", function() { return PrevisionsPageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__previsions__ = __webpack_require__(889);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__pipes_pipes_module__ = __webpack_require__(484);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};




var PrevisionsPageModule = /** @class */ (function () {
    function PrevisionsPageModule() {
    }
    PrevisionsPageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__previsions__["a" /* PrevisionsPage */],
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__previsions__["a" /* PrevisionsPage */]),
                __WEBPACK_IMPORTED_MODULE_3__pipes_pipes_module__["a" /* PipesModule */]
            ],
        })
    ], PrevisionsPageModule);
    return PrevisionsPageModule;
}());

//# sourceMappingURL=previsions.module.js.map

/***/ }),

/***/ 889:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return PrevisionsPage; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__providers_manager_manager__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__app_app_notify__ = __webpack_require__(482);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_moment__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_moment___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4_moment__);
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






var PrevisionsPage = /** @class */ (function () {
    function PrevisionsPage(navCtrl, modalCtrl, localisation, manager, loadingCtrl, notify, navParams) {
        this.navCtrl = navCtrl;
        this.modalCtrl = modalCtrl;
        this.localisation = localisation;
        this.manager = manager;
        this.loadingCtrl = loadingCtrl;
        this.notify = notify;
        this.navParams = navParams;
        this.previsions = [];
        this.queryText = '';
    }
    PrevisionsPage.prototype.ionViewDidLoad = function () {
        this.refresh();
    };
    PrevisionsPage.prototype.refresh = function () {
        this.filtre = { type: '',
            user: '', secteur: '',
            ville: '',
            afterdate: __WEBPACK_IMPORTED_MODULE_4_moment__().startOf('week').format("YYYY-MM-DD"),
            beforedate: __WEBPACK_IMPORTED_MODULE_4_moment__().endOf('week').format("YYYY-MM-DD") };
        if (this.localisation.isOnline())
            return this.loadRemoteData();
        return this.loadData();
    };
    PrevisionsPage.prototype.loadData = function () {
        var _this = this;
        this.loading = true;
        this.manager.get('prevision').then(function (data) {
            _this.previsions = data ? data : [];
            _this.loading = false;
        }, function (error) {
            _this.notify.onSuccess({ message: "PROBLEME ! Verifiez votre connexion internet" });
        });
    };
    ;
    PrevisionsPage.prototype.loadRemoteData = function () {
        var _this = this;
        var loader = this.loadingCtrl.create({
            content: "chargement...",
        });
        this.loading = true;
        this.manager.get('prevision', true, null, null, this.filtre, 1).then(function (data) {
            _this.previsions = data ? data : [];
            console.log(_this.previsions);
            _this.loading = false;
            loader.dismiss();
        }, function (error) {
            loader.dismiss();
            console.log(error);
            _this.notify.onSuccess({ message: "PROBLEME ! Verifiez votre connexion internet" });
        });
        loader.present();
    };
    PrevisionsPage.prototype.openFilter = function () {
        var _this = this;
        var modal = this.modalCtrl.create('FiltreStatsPage', { filtre: this.filtre });
        modal.onDidDismiss(function (data) {
            if (!data)
                return;
            return _this.loadRemoteData();
        });
        modal.present();
    };
    PrevisionsPage.prototype.search = function () {
        var _this = this;
        var queryText = this.queryText.toLowerCase().replace(/,|\.|-/g, ' ');
        var queryWords = queryText.split(' ').filter(function (w) { return !!w.trim().length; });
        this.previsions.forEach(function (item) {
            item.hide = true;
            _this.filter(item, queryWords);
        });
    };
    PrevisionsPage.prototype.filter = function (item, queryWords) {
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
    PrevisionsPage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'page-previsions',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\previsions\previsions.html"*/'\n<ion-header>\n  <ion-navbar>\n      <ion-row no-padding>\n          <ion-col> <ion-title >Prévisions sur les livraisons</ion-title></ion-col>\n          <ion-col>\n            <ion-searchbar [hidden]="!previsions.length"  [(ngModel)]="queryText" (ionInput)="search()" placeholder="Recherchez un produit">\n            </ion-searchbar>         \n          </ion-col>\n        </ion-row>\n        <ion-buttons end>\n            <button ion-button icon-only (click)="refresh()"> \n              <ion-icon name="refresh"></ion-icon> \n            </button>       \n          </ion-buttons>        \n  </ion-navbar>\n</ion-header>\n<ion-content >\n    <ion-card>\n        <ion-card-header>\n          <ion-item text-wrap>\n              Prévisions sur les livraisons  <strong *ngIf="filtre"><span *ngIf="filtre.afterdate">, Entre le {{filtre.afterdate|date:\'dd/MM/yyyy\'}}</span>\n                <span *ngIf="filtre.beforedate"> <span *ngIf="filtre.afterdate">et</span><span *ngIf="!filtre.afterdate">, Avant</span> le {{filtre.beforedate|date:\'dd/MM/yyyy\'}}</span></strong>\n              <p *ngIf="filtre">\n                  <span *ngIf="filtre.type">, {{filtre.type}}</span><span *ngIf="!filtre.type">Toutes catégories</span>\n                  <span *ngIf="filtre.ville">{{filtre.ville}}</span><span *ngIf="!filtre.ville">, toutes les villes</span>\n                 <span *ngIf="filtre.quartier">, {{filtre.quartier}}</span><span *ngIf="!filtre.quartier">, tous les quartiers</span>\n              </p>\n                  <button ion-button icon-left item-right    (click)="openFilter()"><ion-icon name="funnel"  ></ion-icon> Seletionnez</button>    \n          </ion-item>\n        </ion-card-header>\n      </ion-card>  \n    <ion-list *ngIf="previsions.length">\n        <ion-item  *ngFor="let produit of previsions"  [hidden]="produit.hide">\n            {{produit.nom}}\n            <p>{{produit.description}}</p>\n            <p *ngIf="produit.next_cmd_date">{{produit.next_cmd_quantity}} à partir de  {{produit.next_cmd_date|moment}} </p> \n              <ion-badge *ngIf="produit.next_cmd_quantity" item-right> {{produit.next_cmd_quantity}} colis</ion-badge>\n        </ion-item>  \n    </ion-list>\n    <ion-grid style="justify-content: center;height: 100%;" *ngIf="loading"> \n        <ion-row style="justify-content: center;height: 100%;" justify-content-center align-items-center>\n            <ion-spinner name="ios"></ion-spinner>\n        </ion-row>\n      </ion-grid> \n      <ion-grid style="height: 80%;justify-content: center;position:absolute;top:20%" *ngIf="!previsions.length&&!loading">\n          <ion-row style="height: 100%;justify-content: center;" justify-content-center align-items-center>\n              <div text-center text-wrap  class="empty" padding>\n                Aucune prévision possible à partir des données connues.\n              </div>\n          </ion-row>\n        </ion-grid>        \n</ion-content>\n'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\previsions\previsions.html"*/,
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["n" /* NavController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["l" /* ModalController */],
            __WEBPACK_IMPORTED_MODULE_5__providers_localisation_localisation__["a" /* LocalisationProvider */],
            __WEBPACK_IMPORTED_MODULE_2__providers_manager_manager__["a" /* ManagerProvider */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["j" /* LoadingController */],
            __WEBPACK_IMPORTED_MODULE_3__app_app_notify__["a" /* AppNotify */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["o" /* NavParams */]])
    ], PrevisionsPage);
    return PrevisionsPage;
}());

//# sourceMappingURL=previsions.js.map

/***/ })

});
//# sourceMappingURL=25.js.map