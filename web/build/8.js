webpackJsonp([8],{

/***/ 860:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "VendeursPageModule", function() { return VendeursPageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__vendeurs__ = __webpack_require__(915);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



var VendeursPageModule = /** @class */ (function () {
    function VendeursPageModule() {
    }
    VendeursPageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__vendeurs__["a" /* VendeursPage */],
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__vendeurs__["a" /* VendeursPage */]),
            ],
        })
    ], VendeursPageModule);
    return VendeursPageModule;
}());

//# sourceMappingURL=vendeurs.module.js.map

/***/ }),

/***/ 915:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return VendeursPage; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__ionic_storage__ = __webpack_require__(88);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__providers_manager_manager__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__providers_user_user__ = __webpack_require__(152);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__app_app_notify__ = __webpack_require__(482);
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
 * Generated class for the VendeursPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */
var VendeursPage = /** @class */ (function () {
    function VendeursPage(navCtrl, loadingCtrl, manager, userService, notify, storage, navParams) {
        this.navCtrl = navCtrl;
        this.loadingCtrl = loadingCtrl;
        this.manager = manager;
        this.userService = userService;
        this.notify = notify;
        this.storage = storage;
        this.navParams = navParams;
        this.vendeurs = [];
        this.requesteds = [];
        this.queryText = '';
        this.loading = false;
    }
    VendeursPage.prototype.ionViewDidLoad = function () {
        this.loadData();
    };
    VendeursPage.prototype.loadData = function () {
        var _this = this;
        this.loading = true;
        this.manager.get('user', true).then(function (data) {
            _this.vendeurs = data ? data : [];
            _this.loading = false;
        }, function (error) {
            _this.notify.onError({ message: " Verifiez votre connexion internet" });
        });
    };
    VendeursPage.prototype.loadRemoteData = function () {
        var _this = this;
        var loader = this.notify.loading({
            content: "chargement...",
        });
        this.loading = true;
        this.manager.get('user', true).then(function (data) {
            _this.vendeurs = data ? data : [];
            _this.loading = false;
            loader.dismiss();
        }, function (error) {
            loader.dismiss();
            _this.notify.onError({ message: "Verifiez votre connexion internet" });
        });
        loader.present();
    };
    VendeursPage.prototype.add = function () {
        var _this = this;
        var self = this;
        this.notify.showAlert({
            subTitle: "Nouveau vendeur",
            message: 'Ajouter un membre a votre equipe de vente',
            inputs: [
                {
                    name: 'nom',
                    type: 'text',
                    placeholder: 'Saisir le nom',
                    value: ''
                },
                {
                    name: 'username',
                    type: 'tel',
                    placeholder: 'Numero de telephone',
                    value: ''
                }
            ],
            buttons: [
                {
                    text: 'Annuler',
                    handler: function () {
                        console.log('Disagree clicked');
                    }
                },
                {
                    text: 'Inviter',
                    handler: function (data) {
                        if (!data.username || data.username == self.userService.user.username)
                            return;
                        var loader = _this.notify.loading({
                            content: "Invitation...",
                        });
                        self.manager.save('request', data, true).then(function (req) {
                            loader.dismiss().then(function () {
                                if (!req.id)
                                    return;
                                _this.requesteds.splice(0, 0, req);
                                _this.notify.onSuccess({ message: "Demande envoyee !" });
                            });
                        }, function (error) {
                            loader.dismiss();
                            _this.notify.onError({ message: "Verifiez votre connexion internet" });
                        });
                        loader.present();
                    }
                }
            ]
        });
    };
    VendeursPage.prototype.deleteRequest = function (requested) {
        var _this = this;
        var loader = this.notify.loading({
            content: "Suppression...",
        });
        this.manager.delete('request', requested, 'delete', true).then(function (data) {
            if (data.ok) {
                loader.dismiss().then(function () {
                    var index = _this.requesteds.findIndex(function (item) { return item.id == data.deletedId; });
                    if (index > -1)
                        _this.requesteds.splice(index, 1);
                    _this.notify.onSuccess({ message: "Element supprime" });
                });
            }
            else {
                loader.dismiss();
                _this.notify.onError({ message: "Cet element est lie a d'autres. Vous ne pouvez pas le supprimer" });
            }
        }, function (error) {
            loader.dismiss();
            _this.notify.onError({ message: "Un probleme est survenu" });
        });
        loader.present();
    };
    VendeursPage.prototype.deleteUser = function (user) {
        var _this = this;
        this.notify.showAlert({
            title: "Suppression",
            message: "Voulez-vous supprimer ce vendeur de votre equipe ?",
            buttons: [
                {
                    text: 'Annuler',
                    handler: function () {
                        console.log('Disagree clicked');
                    }
                },
                {
                    text: 'Supprimer',
                    handler: function (data) {
                        var loader = _this.notify.loading({
                            content: "Suppression...",
                        });
                        _this.manager.delete('user', user, 'delete', true).then(function (data) {
                            if (data.ok) {
                                loader.dismiss().then(function () {
                                    var index = _this.vendeurs.findIndex(function (item) { return item.id == data.deletedId; });
                                    _this.vendeurs.splice(index, 1);
                                    _this.notify.onSuccess({ message: "Element supprime" });
                                });
                            }
                            else {
                                loader.dismiss();
                                _this.notify.onError({ message: "Cet element est lie a d'autres. Vous ne pouvez pas le supprimer" });
                            }
                        }, function (error) {
                            loader.dismiss();
                            _this.notify.onError({ message: "Un probleme est survenu" });
                        });
                        loader.present();
                    }
                }
            ]
        });
    };
    VendeursPage.prototype.search = function () {
        var _this = this;
        var queryText = this.queryText.toLowerCase().replace(/,|\.|-/g, ' ');
        var queryWords = queryText.split(' ').filter(function (w) { return !!w.trim().length; });
        this.vendeurs.forEach(function (item) {
            item.hide = true;
            _this.filter(item, queryWords);
        });
    };
    VendeursPage.prototype.filter = function (item, queryWords) {
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
    VendeursPage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'page-vendeurs',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\vendeurs\vendeurs.html"*/'<ion-header no-border no-shadow>\n    <ion-navbar>\n      <ion-title>Les vendeurs</ion-title>\n      <ion-buttons end>\n      <button ion-button="ion-button" icon-only (click)="loadRemoteData()" >\n          <ion-icon name="refresh"></ion-icon>\n      </button>\n      <button ion-button small outline (click)="add()" icon-left>\n            <ion-icon name="add" ></ion-icon>\n            Inviter\n        </button>           \n  </ion-buttons>    \n    </ion-navbar>\n  </ion-header>\n  <ion-content>\n    <!--  <ion-searchbar [hidden]="!vendeurs.length" [(ngModel)]="queryText" (ionInput)="search()" placeholder="Recherchez un nom">\n        </ion-searchbar>  -->   \n      <ion-list *ngIf="(vendeurs.length)">\n          <div *ngIf="vendeurs.length">\n         <ion-item-divider  color="light">Mon equipe de vente ({{vendeurs.length}} membres)</ion-item-divider> \n          <ion-item  *ngFor="let vendeur of vendeurs"  [hidden]="vendeur.hide||vendeur.id==userService.user">\n                <span *ngIf="vendeur.id!=userService.user">{{vendeur.nom}}</span> \n              <p *ngIf="vendeur.id!=userService.user">{{vendeur.phone}}</p>          \n               <button  ion-button outline color="danger" (click)="deleteUser(vendeur)" only-icon small item-right color="danger">\n                    <span>\n                        <ion-icon  name="close"></ion-icon>\n                    </span>\n               </button>  \n          </ion-item>\n          </div>\n          <div *ngIf="requesteds.length">\n          <ion-item-divider  color="light">Demandes envoyees ({{requesteds.length}})</ion-item-divider> \n          <ion-item  *ngFor="let requested of requesteds"  [hidden]="requested.hide">\n                 {{requested.user.nom}}\n              <p>{{requested.user.phone}}</p>\n              <button  ion-button clear color="danger" small item-right (click)="deleteRequest(requested)" color="danger">\n                    <span>Annuler\n                        <ion-icon  name="close"></ion-icon>\n                    </span>\n               </button>              \n          </ion-item> \n          </div>       \n      </ion-list>\n      <ion-grid style="justify-content: center;height: 100%;" *ngIf="(!vendeurs.length&&!requesteds.length)||loading">\n          <ion-row style="justify-content: center;height: 100%;" justify-content-center align-items-center>\n              <ion-spinner name="ios"></ion-spinner>\n          </ion-row>\n        </ion-grid>       \n  </ion-content>'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\vendeurs\vendeurs.html"*/,
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["n" /* NavController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["j" /* LoadingController */],
            __WEBPACK_IMPORTED_MODULE_3__providers_manager_manager__["a" /* ManagerProvider */],
            __WEBPACK_IMPORTED_MODULE_4__providers_user_user__["a" /* UserProvider */],
            __WEBPACK_IMPORTED_MODULE_5__app_app_notify__["a" /* AppNotify */],
            __WEBPACK_IMPORTED_MODULE_2__ionic_storage__["b" /* Storage */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["o" /* NavParams */]])
    ], VendeursPage);
    return VendeursPage;
}());

//# sourceMappingURL=vendeurs.js.map

/***/ })

});
//# sourceMappingURL=8.js.map