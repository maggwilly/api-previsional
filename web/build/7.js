webpackJsonp([7],{

/***/ 824:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "CommendeCreatePageModule", function() { return CommendeCreatePageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__commende_create__ = __webpack_require__(872);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



var CommendeCreatePageModule = /** @class */ (function () {
    function CommendeCreatePageModule() {
    }
    CommendeCreatePageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__commende_create__["a" /* CommendeCreatePage */],
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__commende_create__["a" /* CommendeCreatePage */]),
            ],
        })
    ], CommendeCreatePageModule);
    return CommendeCreatePageModule;
}());

//# sourceMappingURL=commende-create.module.js.map

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

/***/ 872:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return CommendeCreatePage; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__ionic_storage__ = __webpack_require__(88);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__providers_manager_manager__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__app_app_notify__ = __webpack_require__(482);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__angular_common__ = __webpack_require__(65);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__home_home__ = __webpack_require__(864);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};







var CommendeCreatePage = /** @class */ (function () {
    function CommendeCreatePage(navCtrl, alertCtrl, navParams, manager, loadingCtrl, notify, storage) {
        this.navCtrl = navCtrl;
        this.alertCtrl = alertCtrl;
        this.navParams = navParams;
        this.manager = manager;
        this.loadingCtrl = loadingCtrl;
        this.notify = notify;
        this.storage = storage;
        this.produits = [];
        this.commende = { lignes: [], typeInsident: 'Rien à signaler' };
        this.pointVente = {};
        this.queryText = '';
        this.pointVente = navParams.get('pointVente');
        this.commende.pointVenteItem = this.pointVente;
        this.commende.pointVente = this.pointVente.id;
        var datePipe = new __WEBPACK_IMPORTED_MODULE_5__angular_common__["d" /* DatePipe */]('en');
        this.commende.date = datePipe.transform(new Date(), 'yyyy-MM-dd');
    }
    CommendeCreatePage.prototype.ionViewDidLoad = function () {
        this.loadData();
    };
    CommendeCreatePage.prototype.loadData = function () {
        var _this = this;
        this.storage.get('_produits').then(function (data) {
            _this.produits = data;
            _this.manager.get('produit').then(function (data) {
                _this.produits = data ? data : [];
                _this.storage.set('_produits', _this.produits);
            }, function (error) {
                _this.notify.onError({ message: "PROBLEME ! Verifiez votre connexion internet" });
            });
        });
    };
    CommendeCreatePage.prototype.save = function () {
        var _this = this;
        var loader = this.loadingCtrl.create({});
        this.manager.post('commende', this.commende).then(function () {
            _this.notify.onSuccess({ message: "enregistrement effectué" });
            _this.navCtrl.setRoot(__WEBPACK_IMPORTED_MODULE_6__home_home__["a" /* HomePage */], {}, { animate: true, direction: 'forward' });
            loader.dismiss();
        }, function (error) {
            console.log(error);
            loader.dismiss();
            _this.notify.onError({ message: "PROBLEME ! Verifiez votre connexion internet" });
        });
        loader.present();
    };
    CommendeCreatePage.prototype.getPointVente = function (commende) {
        return commende.pointVenteItem ? commende.pointVenteItem : commende.pointVente;
    };
    CommendeCreatePage.prototype.openCart = function () {
        this.navCtrl.push('CommendesViewPage', { commende: this.commende });
    };
    CommendeCreatePage.prototype.addInCart = function (produit) {
        var _this = this;
        var confirm = this.alertCtrl.create({
            title: 'AJOUTER UN PRODUIT',
            inputs: [
                {
                    name: 'quantite',
                    type: 'number',
                    label: 'Quantité',
                    placeholder: 'quantité',
                    value: '1'
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
                    text: 'Ajouter',
                    handler: function (data) {
                        if (data.quantite) {
                            _this.removeFromCart({ produit: produit.id });
                            _this.commende.lignes.push({ produit: produit.id, quantite: data.quantite, produitItem: produit });
                        }
                    }
                }
            ]
        });
        confirm.present();
    };
    CommendeCreatePage.prototype.TotalQuantity = function (commende) {
        var total = 0;
        commende.lignes.forEach(function (ligne) {
            total += Number(ligne.quantite);
        });
        return total;
    };
    CommendeCreatePage.prototype.removeFromCart = function (ligne) {
        var index = this.commende.lignes.findIndex(function (item) { return (item.produit == ligne.produit); });
        if (index > -1)
            this.commende.lignes.splice(index, 1);
    };
    CommendeCreatePage.prototype.search = function () {
        var _this = this;
        var queryText = this.queryText.toLowerCase().replace(/,|\.|-/g, ' ');
        var queryWords = queryText.split(' ').filter(function (w) { return !!w.trim().length; });
        this.produits.forEach(function (item) {
            item.hide = true;
            _this.filter(item, queryWords);
        });
    };
    CommendeCreatePage.prototype.filter = function (item, queryWords) {
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
    CommendeCreatePage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'page-commende-create',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\commende-create\commende-create.html"*/'<ion-header>\n    <ion-navbar>\n        <ion-title *ngIf="getPointVente(commende)">{{commende.date|date:\'dd/MM/yyyy\' }} - {{getPointVente(commende).nom}} </ion-title>\n        <ion-buttons end="end">\n            <button ion-button="ion-button" outline color="white" (click)="openCart()" >\n                <span>{{TotalQuantity(commende)}} \n                </span>\n            </button>\n            <button ion-button icon-only (click)="save()" *ngIf="commende.lignes.length">\n                <ion-icon name="done-all"></ion-icon>\n            </button>           \n        </ion-buttons>\n    </ion-navbar>\n</ion-header>\n<ion-content  padding>\n        <ion-list> \n             <ion-item>\n                <ion-label color="primary" flotting><span>Date du rapport</span></ion-label>\n                <ion-datetime \n                   displayFormat="DD/MM/YYYY"\n                   pickerFormat="D MMM  YYYY" min="2019" max="2050"\n                   doneText="Terminé" cancelText="Annuler"\n                   name="date"\n                   [(ngModel)]="commende.date"\n                    #date="ngModel"></ion-datetime>\n              </ion-item>\n    </ion-list> \n<ion-list-header>Selectionnez un produit</ion-list-header>\n    <ion-list>\n        <ion-item  *ngFor="let produit of produits" (click)="addInCart(produit)" [hidden]="produit.hide">\n            {{produit.nom}}\n            <p>{{produit.description}}</p>\n            <ion-note item-right>{{produit.cout}} XAF</ion-note>\n        </ion-item>\n    </ion-list>\n    <ion-item>\n     <ion-label color="primary" floating>\n            <span>Insident à signaler</span>\n     </ion-label>\n     <ion-select [(ngModel)]="commende.typeInsident" name="typeInsident" #typeInsident="ngModel" required="required">\n                <ion-option value="Rien à signaler">Rien à signaler</ion-option>\n                <ion-option value="Insident portant sur le matériel">Insident portant sur le matériel</ion-option>\n                <ion-option value="Insident avec un souscripteur ou un prospect">Insident avec un souscripteur</ion-option>\n                <ion-option value="Insident de santé leger">Insident de santé leger</ion-option>\n                <ion-option value="Accident ayant occasionné des blessures ">Accident ayant occasionné des blessures</ion-option>\n                <ion-option value="Autre type d\'insident">Autre type d\'insident</ion-option>\n    </ion-select>\n    </ion-item>    \n    <ion-item *ngIf="commende.typeInsident!=\'Rien à signaler\'">\n        <ion-textarea rows="3" [(ngModel)]="commende.description" placeholder="Compte rendu descriptif"\n            name="description" #description="ngModel"></ion-textarea>\n    </ion-item>    \n</ion-content>'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\commende-create\commende-create.html"*/,
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["n" /* NavController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["a" /* AlertController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["o" /* NavParams */],
            __WEBPACK_IMPORTED_MODULE_3__providers_manager_manager__["a" /* ManagerProvider */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["j" /* LoadingController */],
            __WEBPACK_IMPORTED_MODULE_4__app_app_notify__["a" /* AppNotify */],
            __WEBPACK_IMPORTED_MODULE_2__ionic_storage__["b" /* Storage */]])
    ], CommendeCreatePage);
    return CommendeCreatePage;
}());

//# sourceMappingURL=commende-create.js.map

/***/ })

});
//# sourceMappingURL=7.js.map