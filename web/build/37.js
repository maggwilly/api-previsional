webpackJsonp([37],{

/***/ 825:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "CommendesViewPageModule", function() { return CommendesViewPageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__commendes_view__ = __webpack_require__(873);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



var CommendesViewPageModule = /** @class */ (function () {
    function CommendesViewPageModule() {
    }
    CommendesViewPageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__commendes_view__["a" /* CommendesViewPage */],
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__commendes_view__["a" /* CommendesViewPage */]),
            ],
        })
    ], CommendesViewPageModule);
    return CommendesViewPageModule;
}());

//# sourceMappingURL=commendes-view.module.js.map

/***/ }),

/***/ 873:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return CommendesViewPage; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__providers_manager_manager__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__app_app_notify__ = __webpack_require__(482);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__providers_user_user__ = __webpack_require__(152);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_moment__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_moment___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5_moment__);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};






var CommendesViewPage = /** @class */ (function () {
    function CommendesViewPage(navCtrl, manager, userService, modalCtrl, events, notify, app, navParams) {
        this.navCtrl = navCtrl;
        this.manager = manager;
        this.userService = userService;
        this.modalCtrl = modalCtrl;
        this.events = events;
        this.notify = notify;
        this.app = app;
        this.navParams = navParams;
        this.commende = { lignes: [] };
        this.activeItemSliding = null;
        this.editing = false;
        this.edited = false;
        this.pointVente = {};
        this.submitted = true;
        this.commende = this.navParams.get('commende');
        if (!this.commende.date)
            this.commende.date = __WEBPACK_IMPORTED_MODULE_5_moment__().format("YYYY-MM-DD HH:mm");
        this.pointVente = this.commende.pointVente;
    }
    CommendesViewPage.prototype.ionViewDidEnter = function () {
        var _this = this;
        if (!this.commende.id) {
            this.edited = true;
            return;
        }
        this.manager.show('commende', this.commende.id).then(function (data) {
            _this.commende = data;
            _this.edited = false;
            _this.submitted = false;
        }, function (error) {
            _this.notify.onError({ message: "Verifiez votre connexion internet" });
        });
    };
    CommendesViewPage.prototype.canEdit = function () {
        return this.commende.terminated && this.userService.amIMyParent() || !this.commende.terminated;
    };
    CommendesViewPage.prototype.deleteItem = function (list, index) {
        if (!this.canEdit())
            return;
        list.splice(index, 1);
        this.edited = true;
        this.editing = false;
    };
    CommendesViewPage.prototype.delete = function () {
        var _this = this;
        if (!this.canEdit())
            return;
        this.notify.showAlert({
            title: "Suppression",
            message: "Voulez-vous supprimer cet element ?",
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
                        _this.manager.delete('commende', _this.commende).then(function (data) {
                            if (data.ok) {
                                loader.dismiss().then(function () {
                                    _this.commende.deleted = true;
                                    _this.pointVente.lastCommende = null;
                                    _this.manager.storeEntityLocally('pointvente', null);
                                    _this.events.publish('commende.added', null);
                                    _this.app.getActiveNav().pop();
                                    _this.notify.onSuccess({ message: "Element supprime" });
                                });
                            }
                            else {
                                loader.dismiss();
                                _this.notify.onError({ message: "Cet element est lié a d'autres. Vous ne pouvez pas le supprimer" });
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
    CommendesViewPage.prototype.toggleEditing = function () {
        this.editing = !this.editing;
        this.closeOption();
    };
    CommendesViewPage.prototype.terminate = function () {
        var _this = this;
        this.commende.terminated = true;
        this.commende.change = true;
        var loader = this.notify.loading({ content: 'Enregistrement ...' });
        this.manager.save('commende', this.commende).then(function (data) {
            loader.dismiss().then(function () {
                if (!data.error) {
                    _this.edited = false;
                    _this.commende = data;
                    _this.events.publish('commende.update', data);
                    return _this.notify.onSuccess({ message: "Enregistrement effectué" });
                }
                _this.commende.terminated = false;
                _this.notify.onError({ message: "Une erreur s'est produite" });
            });
        }, function (error) {
            _this.commende.terminated = false;
            loader.dismiss();
            _this.notify.onError({ message: "Verifiez votre connexion internet" });
        });
        loader.present();
    };
    CommendesViewPage.prototype.save = function () {
        var _this = this;
        this.commende.change = true;
        var loader = this.notify.loading({ content: 'Enregistrement ...' });
        this.manager.save('commende', this.commende).then(function (data) {
            loader.dismiss().then(function () {
                if (!data.error) {
                    _this.edited = false;
                    _this.pointVente.lastCommende = {
                        id: _this.commende.id,
                        date: _this.commende.date
                    };
                    // this.manager.storeEntityLocally('pointvente', this.pointVente)
                    _this.events.publish('commende.added', data);
                    return _this.notify.onSuccess({ message: "Enregistrement effectué" });
                }
                _this.notify.onError({ message: "Une erreur s'est produite " });
            });
        }, function (error) {
            loader.dismiss();
            _this.notify.onError({ message: "Verifiez votre connexion internet" });
        });
        loader.present();
    };
    CommendesViewPage.prototype.addItem = function () {
        var _this = this;
        var modal = this.modalCtrl.create('SelectproduitPage');
        modal.onDidDismiss(function (data) {
            if (!data)
                return;
            var modal = _this.modalCtrl.create('CreatelignePage', { produit: data }, { cssClass: 'inset-modal' });
            modal.onDidDismiss(function (data) {
                if (!data)
                    return;
                _this.edited = true;
                var index = _this.commende.lignes.findIndex(function (item) { return item.produit == data.produit; });
                if (index > 0)
                    _this.commende.lignes.splice(index, 1);
                _this.commende.lignes.push(data);
                _this.commende.total += Number(data.total);
            });
            modal.present();
        });
        modal.present();
    };
    CommendesViewPage.prototype.openOption = function (itemSlide, item, event) {
        event.stopPropagation(); // here if you want item to be tappable
        if (this.activeItemSliding) {
            this.closeOption();
        }
        this.activeItemSliding = itemSlide;
        var swipeAmount = 100; // set your required swipe amount
        itemSlide.startSliding(swipeAmount);
        itemSlide.moveSliding(swipeAmount);
        itemSlide.setElementClass('active-slide', true);
        itemSlide.setElementClass('active-options-right', true);
        item.setElementStyle('transition', null);
        item.setElementStyle('transform', 'translate3d(-' + swipeAmount + 'px, 0px, 0px)');
    };
    CommendesViewPage.prototype.closeOption = function () {
        if (this.activeItemSliding) {
            this.activeItemSliding.close();
            this.activeItemSliding = null;
        }
    };
    CommendesViewPage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'page-commendes-view',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\commendes-view\commendes-view.html"*/'<ion-header>\n  <ion-navbar>\n      <ion-title >\n         <span *ngIf="!commende.numFacture">Enregistrer une vente </span>\n         <span *ngIf="commende.numFacture">Vente - #{{commende.numFacture}}</span>\n        </ion-title>\n      <ion-buttons   end  *ngIf="commende.lignes&&commende.lignes.length" [hidden]="commende.terminated">\n        <button ion-button [hidden]="editing" small outline  icon-left (click)="toggleEditing()">\n          <ion-icon name="trash" color="danger"></ion-icon>\n          Modifier\n      </button>  \n        <button ion-button [hidden]="!editing" small outline  icon-left (click)="toggleEditing()" >\n            <ion-icon name="close" color="primary" ></ion-icon>\n            Annuler\n        </button>    \n    </ion-buttons>    \n  </ion-navbar>\n</ion-header>\n<ion-content>\n  <ion-list>\n    <ion-card *ngIf="pointVente">\n        <ion-card-header>{{pointVente.nom}}</ion-card-header>\n        <ion-card-content>\n          <ion-grid>\n          <ion-row><ion-col><strong>Ref-#{{commende.numFacture}}</strong></ion-col>\n            <ion-col *ngIf="commende.date" text-right>{{commende.date|date:\'dd/MM/yyyy HH:mm\' }}</ion-col></ion-row>\n          <ion-row *ngIf="commende.user"><ion-col>{{commende.user.nom}}</ion-col></ion-row>\n         </ion-grid>\n        </ion-card-content>\n      </ion-card>\n        <ion-grid padding style="height: 80%;justify-content: center" [hidden]="!submitted||commende.lignes">\n         <ion-row style="justify-content: center;" justify-content-center align-items-center>    \n       <ion-spinner color="royal" name="ios"></ion-spinner>\n      </ion-row>    \n      </ion-grid>  \n      <ion-card *ngIf="commende.lignes">\n          <ion-row><ion-col>{{commende.lignes.length}} articles</ion-col><ion-col text-right>Total: {{commende.total}} FCFA</ion-col></ion-row>\n        </ion-card> \n        <ion-list-header no-lines no-border *ngIf="commende.lignes" [hidden]="commende.terminated">\n            Cliquer pour ajouter un produit\n            <button item-end ion-button large icon-only clear (click)="addItem()">\n              <ion-icon color="primary" name="add-circle"></ion-icon>\n            </button>\n        </ion-list-header>               \n      <ion-card *ngIf="commende.lignes">\n          <ion-row class="line header" no-padding><ion-col col-4>Designation</ion-col><ion-col col-2>Qte</ion-col><ion-col col-2>P.U</ion-col><ion-col col-2 text-right>Total</ion-col></ion-row>\n          <ion-item-sliding #slidingItem *ngFor="let ligne of commende.lignes; let i = index; ">\n              <ion-item #item>                \n                  <ion-icon [hidden]="!editing" item-start color="danger" name="remove-circle" (click)="openOption(slidingItem, item, $event)"></ion-icon>\n                  <ion-row class="line" no-padding><ion-col col-4>{{ligne.produit.nom}}</ion-col><ion-col col-2>{{ligne.quantite}}</ion-col><ion-col col-2>{{ligne.produit.cout}}</ion-col><ion-col col-2 text-right>{{(ligne.produit.cout * ligne.quantite)}}</ion-col></ion-row>                                  \n           </ion-item>\n           <ion-item-options icon-start (ionSwipe)="deleteItem(commende.lignes, i)" [hidden]="!canEdit()">\n              <button color="danger" (click)="deleteItem(commende.lignes, i)" ion-button icon-left expandable>\n                <ion-icon name="trash"></ion-icon> retirer\n              </button>\n      </ion-item-options>       \n        </ion-item-sliding>\n        </ion-card>\n  </ion-list> \n</ion-content>\n<ion-footer [hidden]="!canEdit()">\n    <button *ngIf="!commende.id" [hidden]="!edited||!(commende.lignes&&commende.lignes.length)" ion-button large full (click)="save()" icon-left >\n      <ion-icon name="save"  ></ion-icon>\n       Enregistrer \n  </button> \n<ion-row *ngIf="commende.id">\n  <ion-col>\n      <button  ion-button outline block (click)="delete()" color="danger" icon-left >\n          <ion-icon name="save"  ></ion-icon>\n           Annuler \n      </button>    \n  </ion-col>\n  <ion-col [hidden]="commende.terminated">\n      <button  [hidden]="!edited||(!(commende.lignes&&commende.lignes.length)&&!commende.id)" ion-button  block (click)="save()" icon-left >\n          <ion-icon name="save"  ></ion-icon>\n           Enregistrer \n      </button>   \n    <button [hidden]="edited"  ion-button block  (click)="terminate()" icon-left color="secondary" >\n      <ion-icon name="done-all"  ></ion-icon>\n      Terminer \n  </button> \n  </ion-col>\n</ion-row>   \n</ion-footer>\n'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\commendes-view\commendes-view.html"*/,
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["n" /* NavController */],
            __WEBPACK_IMPORTED_MODULE_2__providers_manager_manager__["a" /* ManagerProvider */],
            __WEBPACK_IMPORTED_MODULE_4__providers_user_user__["a" /* UserProvider */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["l" /* ModalController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["d" /* Events */],
            __WEBPACK_IMPORTED_MODULE_3__app_app_notify__["a" /* AppNotify */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["b" /* App */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["o" /* NavParams */]])
    ], CommendesViewPage);
    return CommendesViewPage;
}());

//# sourceMappingURL=commendes-view.js.map

/***/ })

});
//# sourceMappingURL=37.js.map