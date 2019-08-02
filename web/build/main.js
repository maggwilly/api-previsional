webpackJsonp([39],{

/***/ 152:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return UserProvider; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__manager_manager__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__ionic_storage__ = __webpack_require__(88);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__ionic_native_firebase_ngx__ = __webpack_require__(348);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_rxjs__ = __webpack_require__(117);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_rxjs___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5_rxjs__);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};






/*
  Generated class for the UserProvider provider.

  See https://angular.io/guide/dependency-injection for more info on providers
  and Angular DI.
*/
var UserProvider = /** @class */ (function () {
    function UserProvider(manager, storage, app, firebase, events) {
        this.manager = manager;
        this.storage = storage;
        this.app = app;
        this.firebase = firebase;
        this.events = events;
        this.registrationid = window.localStorage.getItem('token_registration');
        this.authenticatedUser = new __WEBPACK_IMPORTED_MODULE_5_rxjs__["BehaviorSubject"](null);
        this.complete = null;
        this.resetObserver();
    }
    UserProvider.prototype.resetObserver = function () {
        var _this = this;
        this.complete = this.makeComplete();
        //this.user = null;
        console.log(this.manager.getUserId());
        if (!this.manager.getUserId())
            return this.events.publish('auth', null);
        this.manager.show('token', this.manager.getUserId(), true).then(function (data) {
            if (!data)
                return _this.events.publish('auth', null);
            _this.user = data;
            _this.authenticatedUser.next(_this.user);
            _this.manager.show('user', _this.manager.getUserId(), true).then(function (user) {
                if (!_this.user)
                    return _this.go(user);
                _this.user.parent = user.parent;
                _this.user.receiveRequests = user.receiveRequests;
                _this.manager.storeEntityLocally("user", _this.user);
                _this.amParent = _this.amIMyParent();
                _this.events.publish('user.login', {
                    user: _this.user
                });
            }, function (error) {
                _this.events.publish('error', error);
            });
        });
    };
    UserProvider.prototype.getAuthenticatedUser = function () {
        return this.authenticatedUser;
    };
    UserProvider.prototype.go = function (user) {
        console.log(user);
        this.app.getRootNav().setRoot('SignupPage', {}, { animate: false });
    };
    UserProvider.prototype.request = function (requests) {
        this.app.getRootNav().setRoot('RequestsPage', { requests: requests }, { animate: false });
    };
    UserProvider.prototype.profile = function (user) {
        this.app.getRootNav().setRoot('ProfilePage', { user: user });
    };
    UserProvider.prototype.shoulpay = function (abonnement) {
        this.app.getRootNav().setRoot('ShoulPayPage', { abonnement: abonnement });
    };
    UserProvider.prototype.unavailable = function () {
        this.app.getRootNav().setRoot('UnavailablePage');
    };
    UserProvider.prototype.amIMyParent = function () {
        if (!this.user || !this.user.parent)
            return;
        return (this.user.id == this.user.parent.id);
    };
    UserProvider.prototype.makeComplete = function () {
        var self = this;
        return new Promise(function (resolve, reject) {
            if (self.user && self.user.parent) {
                resolve(self.user);
                return;
            }
            self.events.subscribe('user.login', function (data) {
                resolve(data.user);
            });
            self.events.subscribe('auth', function (pb) {
                resolve(pb);
            });
            self.events.subscribe('error', function (error) {
                resolve(error);
            });
        });
    };
    ;
    UserProvider.prototype.getToken = function () {
        var _this = this;
        this.firebase.getToken().then(function (token) {
            _this.registrationid = token;
            window.localStorage.setItem('token_registration', token);
        });
        this.firebase.onTokenRefresh().subscribe(function (token) {
            _this.registrationid = token;
            window.localStorage.setItem('token_registration', token);
        });
        this.getAuthenticatedUser().subscribe(function (user) {
            if (user)
                _this.register(user);
        });
    };
    UserProvider.prototype.logout = function () {
        var _this = this;
        this.manager.removeUser().then(function () {
            _this.storage.clear();
            _this.authenticatedUser.next(null);
            _this.go(_this.user);
        });
    };
    UserProvider.prototype.onNotification = function () {
        var _this = this;
        this.firebase.onNotificationOpen().subscribe(function (data) {
            if (data.tap) {
                if (data.page) {
                    switch (data.page) {
                        case 'should_pay':
                            _this.app.getActiveNav().setRoot('ShouldPayPage');
                            break;
                        default:
                            _this.app.getActiveNav().setRoot('PointVenteDetailPage', { pointVente: data.pointVente });
                            break;
                    }
                }
            }
        });
    };
    UserProvider.prototype.register = function (user) {
        if (!user || !user.id || !user.parent || !this.registrationid)
            return;
        user.registration = this.registrationid;
        this.firebase.subscribe('user-' + user.parent.id);
        this.manager.put('user', user).then(function (data) {
        }, function (error) {
            //this.notify.onSuccess({message:"PROBLEME ! votre connexion internet est peut-être instable"})
        });
    };
    UserProvider = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Injectable"])(),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1__manager_manager__["a" /* ManagerProvider */],
            __WEBPACK_IMPORTED_MODULE_2__ionic_storage__["b" /* Storage */],
            __WEBPACK_IMPORTED_MODULE_3_ionic_angular__["b" /* App */],
            __WEBPACK_IMPORTED_MODULE_4__ionic_native_firebase_ngx__["a" /* Firebase */],
            __WEBPACK_IMPORTED_MODULE_3_ionic_angular__["d" /* Events */]])
    ], UserProvider);
    return UserProvider;
}());

//# sourceMappingURL=user.js.map

/***/ }),

/***/ 165:
/***/ (function(module, exports) {

function webpackEmptyAsyncContext(req) {
	// Here Promise.resolve().then() is used instead of new Promise() to prevent
	// uncatched exception popping up in devtools
	return Promise.resolve().then(function() {
		throw new Error("Cannot find module '" + req + "'.");
	});
}
webpackEmptyAsyncContext.keys = function() { return []; };
webpackEmptyAsyncContext.resolve = webpackEmptyAsyncContext;
module.exports = webpackEmptyAsyncContext;
webpackEmptyAsyncContext.id = 165;

/***/ }),

/***/ 210:
/***/ (function(module, exports, __webpack_require__) {

var map = {
	"../pages/about/about.module": [
		822,
		38
	],
	"../pages/cartograph/cartograph.module": [
		823,
		3
	],
	"../pages/commende-create/commende-create.module": [
		824,
		7
	],
	"../pages/commendes-view/commendes-view.module": [
		825,
		37
	],
	"../pages/commendes/commendes.module": [
		826,
		36
	],
	"../pages/createligne/createligne.module": [
		827,
		35
	],
	"../pages/donnees/donnees.module": [
		828,
		34
	],
	"../pages/filtre-pointvente/filtre-pointvente.module": [
		829,
		33
	],
	"../pages/filtre-stats/filtre-stats.module": [
		830,
		32
	],
	"../pages/filtre-vente/filtre-vente.module": [
		831,
		31
	],
	"../pages/help/help.module": [
		832,
		30
	],
	"../pages/home/home.module": [
		833,
		5
	],
	"../pages/map/map.module": [
		834,
		2
	],
	"../pages/menu/menu.module": [
		835,
		29
	],
	"../pages/point-vente-detail/point-vente-detail.module": [
		836,
		6
	],
	"../pages/point-vente/point-vente.module": [
		837,
		28
	],
	"../pages/pointventes/pointventes.module": [
		838,
		27
	],
	"../pages/pop-over-menu/pop-over-menu.module": [
		839,
		26
	],
	"../pages/previsions/previsions.module": [
		840,
		25
	],
	"../pages/price-detail/price-detail.module": [
		841,
		24
	],
	"../pages/produit-detail/produit-detail.module": [
		842,
		23
	],
	"../pages/produit/produit.module": [
		843,
		22
	],
	"../pages/produits/produits.module": [
		844,
		21
	],
	"../pages/profile/profile.module": [
		845,
		20
	],
	"../pages/quartiers/quartiers.module": [
		846,
		1
	],
	"../pages/rapports/rapports.module": [
		847,
		19
	],
	"../pages/rendezvous/rendezvous.module": [
		848,
		18
	],
	"../pages/requests/requests.module": [
		849,
		17
	],
	"../pages/secteur/secteur.module": [
		850,
		16
	],
	"../pages/secteurs/secteurs.module": [
		851,
		15
	],
	"../pages/selectclient/selectclient.module": [
		852,
		14
	],
	"../pages/selectproduit/selectproduit.module": [
		853,
		13
	],
	"../pages/shoul-pay/shoul-pay.module": [
		854,
		12
	],
	"../pages/signup/signup.module": [
		855,
		4
	],
	"../pages/stats/stats.module": [
		856,
		0
	],
	"../pages/tabs/tabs.module": [
		857,
		11
	],
	"../pages/unavailable/unavailable.module": [
		858,
		10
	],
	"../pages/vendeur/vendeur.module": [
		859,
		9
	],
	"../pages/vendeurs/vendeurs.module": [
		860,
		8
	]
};
function webpackAsyncContext(req) {
	var ids = map[req];
	if(!ids)
		return Promise.reject(new Error("Cannot find module '" + req + "'."));
	return __webpack_require__.e(ids[1]).then(function() {
		return __webpack_require__(ids[0]);
	});
};
webpackAsyncContext.keys = function webpackAsyncContextKeys() {
	return Object.keys(map);
};
webpackAsyncContext.id = 210;
module.exports = webpackAsyncContext;

/***/ }),

/***/ 47:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ManagerProvider; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_http__ = __webpack_require__(153);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__ionic_storage__ = __webpack_require__(88);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_rxjs_add_operator_toPromise__ = __webpack_require__(212);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_rxjs_add_operator_toPromise___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3_rxjs_add_operator_toPromise__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_rxjs_add_operator_map__ = __webpack_require__(154);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_rxjs_add_operator_map___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4_rxjs_add_operator_map__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__app_config__ = __webpack_require__(485);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7_rxjs_observable_IntervalObservable__ = __webpack_require__(213);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7_rxjs_observable_IntervalObservable___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_7_rxjs_observable_IntervalObservable__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8_guid_typescript__ = __webpack_require__(515);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8_guid_typescript___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_8_guid_typescript__);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};









var ManagerProvider = /** @class */ (function () {
    //baseUrl: string = 'http://localhost:8000';
    function ManagerProvider(http, storage, events) {
        var _this = this;
        this.http = http;
        this.storage = storage;
        this.events = events;
        this.headers = new __WEBPACK_IMPORTED_MODULE_1__angular_http__["a" /* Headers */]({ 'Content-Type': 'application/json' });
        this.keys = [];
        this.isAscing = false;
        this.connected = true;
        // console.log(window.localStorage.getItem('_user_token'));
        //this.headers.set('X-Auth-Token', window.localStorage.getItem('_user_token'))
        if (this.readCookie('_user_token'))
            this.storeUser({ id: this.readCookie('_user_id_'), apiKey: this.readCookie('_user_token') }).then(function () {
                console.log(_this.readCookie('_user_token'));
                console.log(_this.readCookie('_user_id_'));
            });
        // this.headers.set('X-Auth-Token', this.readCookie('_user_token'))
        this.storage.keys().then(function (keys) {
            _this.keys = keys;
        });
        this.listenEvents();
        //this.clearStorage()
    }
    ManagerProvider.prototype.clearStorage = function () {
        this.storage.clear();
    };
    ManagerProvider.prototype.listenEvents = function () {
        var _this = this;
        __WEBPACK_IMPORTED_MODULE_6__app_config__["a" /* Config */].entityNames.forEach(function (entityName) {
            _this.events.subscribe("entity:" + entityName + ":change", function (data) {
                if (data && data.change)
                    _this.save(entityName, data, _this.connected).catch(function (error) { return console.log(error); });
            });
            _this.events.subscribe("entity:" + entityName + ":delete", function (data) {
                _this.delete(entityName, data, 'delete', true);
            });
        });
    };
    ManagerProvider.prototype.ascync = function () {
        var promises = [];
        promises.push(this.saveAscyncEntity());
        promises.push(this.deletAascyncEntity());
        promises.push(this.getAascyncEntity());
        return Promise.all(promises);
    };
    ManagerProvider.prototype.saveAscyncEntity = function () {
        var _this = this;
        var promises = [];
        __WEBPACK_IMPORTED_MODULE_6__app_config__["a" /* Config */].entityNames.map(function (entityName) {
            _this.storage.forEach(function (value, key, index) {
                if (key.match("^" + entityName + "+_(id|new)_(([a0-z9]-*)(?!.*[_]deleted$))*$")) {
                    if (value && value.change)
                        return promises.push(_this.save(entityName, value, _this.connected).catch(function (error) { return console.error(error); }));
                }
            });
        });
        return Promise.all(promises);
    };
    ManagerProvider.prototype.deletAascyncEntity = function () {
        var _this = this;
        var promises = [];
        __WEBPACK_IMPORTED_MODULE_6__app_config__["a" /* Config */].entityNames.map(function (entityName) {
            _this.storage.forEach(function (value, key, index) {
                if (key.match("^" + entityName + "+_(id|new)_[a0-z9]*_deleted$")) {
                    if (value && value.change)
                        return promises.push(_this.delete(entityName, value, 'delete', _this.connected).catch(function (error) { return console.error(error); }));
                }
            });
        });
        return Promise.all(promises);
    };
    ManagerProvider.prototype.getAascyncEntity = function () {
        var _this = this;
        var promises = [];
        __WEBPACK_IMPORTED_MODULE_6__app_config__["a" /* Config */].entityNames.map(function (entityName) {
            promises.push(_this.get(entityName, true).catch(function (error) { return console.error(error); }));
        });
        return Promise.all(promises);
    };
    ManagerProvider.prototype.storeUser = function (user) {
        var _this = this;
        return this.storeEntityLocally('user', user).then(function () {
            window.localStorage.setItem('_user_id_', user.id);
            window.localStorage.setItem('_user_token', user.apiKey);
            _this.headers.set('X-Auth-Token', user.apiKey);
        });
    };
    ManagerProvider.prototype.removeUser = function () {
        var _this = this;
        return this.storage.clear().then(function () {
            window.localStorage.clear();
            _this.headers.delete('X-Auth-Token');
        });
    };
    ManagerProvider.prototype.getUserId = function () {
        // let _user_id =  window.localStorage.getItem('_user_id_');
        return this.readCookie('_user_id_'); //_user_id;
    };
    ManagerProvider.prototype.get = function (entityName, online, id, keyIndex, filter, nbrecritere) {
        var _this = this;
        if (filter === void 0) { filter = {}; }
        if (nbrecritere === void 0) { nbrecritere = 0; }
        if (online)
            return new Promise(function (resolve, reject) {
                var criteria = !nbrecritere ? "keys=" + _this.arrayKeys(entityName) : "keys=";
                Object.keys(filter).forEach(function (key) {
                    if (filter[key])
                        criteria = criteria + "&" + key + "=" + filter[key];
                });
                criteria = (id && keyIndex) ? criteria + "&" + keyIndex + "=" + id : criteria;
                console.log(__WEBPACK_IMPORTED_MODULE_6__app_config__["a" /* Config */].server + "/" + entityName + "/json?" + criteria);
                return _this.http.get(__WEBPACK_IMPORTED_MODULE_6__app_config__["a" /* Config */].server + "/" + entityName + "/json?" + criteria, { headers: _this.headers })
                    .toPromise()
                    .then(function (response) {
                    var res = [];
                    return _this.storeEntityLocally(entityName, response.json()).then(function () {
                        if (nbrecritere)
                            return resolve(response.json());
                        _this.getEntitieLocally(entityName, id, keyIndex).then(function (entites) {
                            resolve(entites);
                        });
                    });
                }, function (error) {
                    console.log(error);
                    reject(error);
                });
            });
        return this.getEntitieLocally(entityName, id, keyIndex);
    };
    ManagerProvider.prototype.arrayKeys = function (entityName) {
        var keysString = '';
        var localkeys = this.keys.filter(function (key) { return key.match("^" + entityName + "+_(id|new)_(([a0-z9]-*)(?!.*[_]deleted$))*$"); });
        localkeys.forEach(function (key) {
            var keyparts = key.split('_', 3);
            keysString = keysString + "." + keyparts[2];
        });
        return keysString;
    };
    ManagerProvider.prototype.getText = function (prefix, suffix) {
        if (suffix === void 0) { suffix = ''; }
        return this.http.get(__WEBPACK_IMPORTED_MODULE_6__app_config__["a" /* Config */].server + '/' + prefix + suffix, { headers: this.headers })
            .toPromise()
            .then(function (response) { return response.text(); });
    };
    ManagerProvider.prototype.show = function (entityName, entityid, online, filter) {
        var _this = this;
        if (filter === void 0) { filter = {}; }
        if (online)
            return new Promise(function (resolve, reject) {
                var criteria = '';
                Object.keys(filter).forEach(function (key) {
                    if (filter[key])
                        criteria = criteria + "&" + key + "=" + filter[key];
                });
                console.log(__WEBPACK_IMPORTED_MODULE_6__app_config__["a" /* Config */].server + "/" + entityName + "/" + entityid + "/show/json?id=" + entityid + criteria);
                return _this.http.get(__WEBPACK_IMPORTED_MODULE_6__app_config__["a" /* Config */].server + "/" + entityName + "/" + entityid + "/show/json?id=" + entityid + criteria, { headers: _this.headers })
                    .toPromise()
                    .then(function (response) {
                    var data = response.json();
                    data.change = undefined;
                    _this.storeEntityLocally(entityName, data).then(function (data) { resolve(data); });
                }, function (error) { reject(error); });
            });
        return this.getEntitieLocally(entityName, entityid);
    };
    ManagerProvider.prototype.storeEntityLocally = function (entityName, data, changes) {
        var _this = this;
        return new Promise(function (resolve, reject) {
            if (!Array.isArray(data))
                return _this.storage.set(entityName + "_id_" + data.id, data).then(function () {
                    if (changes && _this.connected)
                        _this.events.publish("entity:" + entityName + ":change", data);
                    resolve(data);
                });
            var promises = [];
            data.forEach(function (element) {
                promises.push(_this.storeEntityLocally(entityName, element));
            });
            return Promise.all(promises).then(function () {
                _this.events.publish("loaded:" + entityName + ":new");
                resolve(data);
            });
        });
    };
    ManagerProvider.prototype.getEntitieLocally = function (entityName, id, keyIndex, start) {
        var _this = this;
        if (start === void 0) { start = 0; }
        if (id && !keyIndex)
            return this.storage.get(entityName + "_id_" + id);
        return new Promise(function (resolve, reject) {
            var entities = [];
            _this.storage.forEach(function (value, key, index) {
                if (key.match("^" + entityName + "+_(id|new)_(([a0-z9]-*)(?!.*[_]deleted$))*$")) {
                    if (keyIndex) {
                        if (value[keyIndex] == id || value[keyIndex] && (value[keyIndex].id == id))
                            entities.push(value);
                    }
                    else
                        entities.push(value);
                }
                resolve(entities);
            });
        });
    };
    ManagerProvider.prototype.post = function (entityName, entity, action, online) {
        var _this = this;
        if (action === void 0) { action = 'new'; }
        if (online)
            return new Promise(function (resolve, reject) {
                console.log(JSON.stringify(entity));
                console.log(__WEBPACK_IMPORTED_MODULE_6__app_config__["a" /* Config */].server + '/' + entityName + '/' + action + '/json');
                _this.http.post(__WEBPACK_IMPORTED_MODULE_6__app_config__["a" /* Config */].server + '/' + entityName + '/' + action + '/json', JSON.stringify(entity), { headers: _this.headers })
                    .toPromise()
                    .then(function (response) {
                    /* if(!response.json().id)
                       return reject({});*/
                    _this.keys.push(entityName + "_id_" + entity.id);
                    return _this.storeEntityLocally(entityName, response.json()).then(function () { resolve(response.json()); });
                }, function (error) {
                    console.log(error);
                    reject(error);
                });
            });
        return this.storeEntityLocally(entityName, entity, true);
    };
    ManagerProvider.prototype.put = function (entityName, entity, online) {
        var _this = this;
        if (online)
            return new Promise(function (resolve, reject) {
                console.log(JSON.stringify(entity));
                console.log(__WEBPACK_IMPORTED_MODULE_6__app_config__["a" /* Config */].server + "/" + entityName + "/" + entity.id + "/edit/json");
                _this.http.put(__WEBPACK_IMPORTED_MODULE_6__app_config__["a" /* Config */].server + "/" + entityName + "/" + entity.id + "/edit/json", JSON.stringify(entity), { headers: _this.headers })
                    .toPromise()
                    .then(function (response) {
                    return _this.storeEntityLocally(entityName, response.json()).then(function () { resolve(response.json()); });
                }, function (error) { return reject(error); });
            });
        return this.storeEntityLocally(entityName, entity, true);
    };
    ManagerProvider.prototype.save = function (entityName, entity, online) {
        if (!entity.change)
            return new Promise(function (resolve, reject) {
                resolve(entity);
            });
        if (entity.change && entity.stored && entity.id)
            return this.put(entityName, entity, online);
        if (!entity.id)
            entity.id = __WEBPACK_IMPORTED_MODULE_8_guid_typescript__["Guid"].create().toString();
        return this.post(entityName, entity, 'new', online);
    };
    ManagerProvider.prototype.delete = function (entityName, entity, target, online) {
        var _this = this;
        if (target === void 0) { target = 'delete'; }
        if (online)
            return new Promise(function (resolve, reject) {
                _this.http.delete(__WEBPACK_IMPORTED_MODULE_6__app_config__["a" /* Config */].server + "/" + entityName + "/" + entity.id + "/" + target + "/json?id=" + entity.id, { headers: _this.headers })
                    .toPromise()
                    .then(function (response) {
                    _this.storage.remove(entityName + "_id_" + entity.id + "_deleted");
                    return resolve(response.json());
                });
            });
        return new Promise(function (resolve, reject) {
            var promises = [];
            console.log(entity);
            promises.push(_this.storage.remove(entityName + "_id_" + entity.id));
            promises.push(_this.storage.set(entityName + "_id_" + entity.id + "_deleted", entity));
            return Promise.all(promises).then(function () {
                _this.events.publish("entity:" + entityName + ":delete", entity);
                resolve({ ok: true, deletedId: entity.id });
            });
        });
    };
    ManagerProvider.prototype.getObservable = function (entityName, entityid) {
        var _this = this;
        return __WEBPACK_IMPORTED_MODULE_7_rxjs_observable_IntervalObservable__["IntervalObservable"]
            .create(1000)
            .flatMap(function (i) { return _this.http.get(__WEBPACK_IMPORTED_MODULE_6__app_config__["a" /* Config */].server + '/' + entityName + '/' + entityid + '/show/json?id=' + entityid, { headers: _this.headers }); });
    };
    ManagerProvider.prototype.getQuartiers = function () {
        return this.http.get('assets/data/quartiers.json')
            .toPromise()
            .then(function (res) { return res.json(); });
    };
    ManagerProvider.prototype.readCookie = function (name) {
        var cookiename = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ')
                c = c.substring(1, c.length);
            if (c.indexOf(cookiename) == 0)
                return c.substring(cookiename.length, c.length);
        }
        return null;
    };
    ManagerProvider = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Injectable"])(),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1__angular_http__["b" /* Http */], __WEBPACK_IMPORTED_MODULE_2__ionic_storage__["b" /* Storage */], __WEBPACK_IMPORTED_MODULE_5_ionic_angular__["d" /* Events */]])
    ], ManagerProvider);
    return ManagerProvider;
}());

//# sourceMappingURL=manager.js.map

/***/ }),

/***/ 482:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return AppNotify; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};

//import { Component } from '@angular/core';

var AppNotify = /** @class */ (function () {
    function AppNotify(toastCtrl, alerttCtrl, loadingCtrl) {
        this.toastCtrl = toastCtrl;
        this.alerttCtrl = alerttCtrl;
        this.loadingCtrl = loadingCtrl;
        this.toastCtrl = toastCtrl;
    }
    AppNotify.prototype.onSuccess = function (toastOpts) {
        var succesToast = this.toastCtrl.create({
            message: toastOpts.message,
            duration: toastOpts.duration || 3000,
            position: toastOpts.position || 'bottom',
            showCloseButton: toastOpts.showCloseButton || true,
            cssClass: 'danger',
        });
        succesToast.present();
    };
    AppNotify.prototype.onError = function (toastOpts) {
        var errorToast = this.toastCtrl.create({
            message: toastOpts.message,
            duration: toastOpts.duration || 7000,
            position: toastOpts.position || 'bottom',
            showCloseButton: toastOpts.showCloseButton || true,
            cssClass: 'success',
        });
        errorToast.present();
    };
    AppNotify.prototype.showAlert = function (alertOptions) {
        var errorToast = this.alerttCtrl.create({
            message: alertOptions.message,
            title: alertOptions.title,
            subTitle: alertOptions.subTitle,
            buttons: alertOptions.buttons || ['Ok'],
            inputs: alertOptions.inputs || []
        });
        errorToast.present();
    };
    AppNotify.prototype.loading = function (loadingOptions) {
        return this.loadingCtrl.create(loadingOptions);
    };
    AppNotify = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Injectable"])(),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["r" /* ToastController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["a" /* AlertController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["j" /* LoadingController */]])
    ], AppNotify);
    return AppNotify;
}());

//# sourceMappingURL=app-notify.js.map

/***/ }),

/***/ 483:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return LocalisationProvider; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__ionic_native_geolocation__ = __webpack_require__(214);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__ionic_native_diagnostic__ = __webpack_require__(218);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__ionic_native_location_accuracy__ = __webpack_require__(219);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__ionic_native_network__ = __webpack_require__(220);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_ionic_angular__ = __webpack_require__(44);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};






var LocalisationProvider = /** @class */ (function () {
    function LocalisationProvider(platform, network, diagnostic, geo, locationAccuracy) {
        this.platform = platform;
        this.network = network;
        this.diagnostic = diagnostic;
        this.geo = geo;
        this.locationAccuracy = locationAccuracy;
        console.log('Hello LocalisationProvider Provider');
    }
    LocalisationProvider.prototype.getCurrentPosition = function () {
        var _this = this;
        return new Promise(function (resolve, reject) {
            var HIGH_ACCURACY = 'high_accuracy';
            if (_this.platform.is('cordova')) {
                _this.platform.ready().then(function () {
                    _this.diagnostic.isLocationEnabled().then(function (enabled) {
                        if (enabled) {
                            if (_this.platform.is('android')) {
                                _this.diagnostic.getLocationMode().then(function (locationMode) {
                                    if (locationMode === HIGH_ACCURACY) {
                                        _this.geo.getCurrentPosition({ timeout: 30000, maximumAge: 0, enableHighAccuracy: true }).then(function (pos) {
                                            resolve(pos);
                                        }).catch(function (error) { return reject(error); });
                                    }
                                    else {
                                        _this.askForHighAccuracy().then(function (available) {
                                            if (available) {
                                                _this.getCurrentPosition().then(function (a) { return resolve(a); }, function (e) { return resolve(e); });
                                            }
                                        }, function (error) { return reject(error); });
                                    }
                                });
                            }
                            else {
                                _this.geo.getCurrentPosition({ timeout: 30000, maximumAge: 0, enableHighAccuracy: true }).then(function (pos) {
                                    resolve(pos);
                                }).catch(function (error) { return reject(error); });
                            }
                        }
                        else {
                            _this.locationAccuracy.canRequest().then(function (canRequest) {
                                if (canRequest) {
                                    _this.locationAccuracy.request(1).then(function (result) {
                                        if (result) {
                                            _this.getCurrentPosition().then(function (result) { return resolve(result); }, function (error) { return reject(error); });
                                        }
                                    }, function (error) {
                                        reject(error);
                                    });
                                }
                                else {
                                    reject('Un Pb empèche de rechercher la position du device');
                                }
                            });
                        }
                    }, function (error) {
                        reject(error);
                    });
                });
            }
            else {
                if ("geolocation" in navigator) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        resolve(position);
                    });
                }
                else
                    _this.geo.getCurrentPosition({ timeout: 30000, maximumAge: 0, enableHighAccuracy: true }).then(function (resp) { return resolve(resp); });
            }
        });
    };
    LocalisationProvider.prototype.askForHighAccuracy = function () {
        var _this = this;
        return new Promise(function (resolve, reject) {
            _this.locationAccuracy
                .request(_this.locationAccuracy.REQUEST_PRIORITY_HIGH_ACCURACY).then(function () {
                _this.geo.getCurrentPosition({ timeout: 30000, maximumAge: 0, enableHighAccuracy: true }).then(function (position) {
                    resolve(position);
                }, function (error) { return reject(error); });
            }, function (error) { return reject(error); });
        });
    };
    LocalisationProvider.prototype.isOnline = function () {
        if (this.onDevice && this.network.Connection) {
            return this.network.Connection !== Connection.NONE;
        }
        else {
            return navigator.onLine;
        }
    };
    LocalisationProvider.prototype.isOffline = function () {
        if (this.onDevice && this.network.Connection) {
            return this.network.Connection === Connection.NONE;
        }
        else {
            return !navigator.onLine;
        }
    };
    LocalisationProvider = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Injectable"])(),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_5_ionic_angular__["p" /* Platform */],
            __WEBPACK_IMPORTED_MODULE_4__ionic_native_network__["a" /* Network */],
            __WEBPACK_IMPORTED_MODULE_2__ionic_native_diagnostic__["a" /* Diagnostic */],
            __WEBPACK_IMPORTED_MODULE_1__ionic_native_geolocation__["a" /* Geolocation */],
            __WEBPACK_IMPORTED_MODULE_3__ionic_native_location_accuracy__["a" /* LocationAccuracy */]])
    ], LocalisationProvider);
    return LocalisationProvider;
}());

//# sourceMappingURL=localisation.js.map

/***/ }),

/***/ 484:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return PipesModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__moment_moment__ = __webpack_require__(800);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};


var PipesModule = /** @class */ (function () {
    function PipesModule() {
    }
    PipesModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [__WEBPACK_IMPORTED_MODULE_1__moment_moment__["a" /* MomentPipe */]],
            imports: [],
            exports: [__WEBPACK_IMPORTED_MODULE_1__moment_moment__["a" /* MomentPipe */]]
        })
    ], PipesModule);
    return PipesModule;
}());

//# sourceMappingURL=pipes.module.js.map

/***/ }),

/***/ 485:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return Config; });
var Config = /** @class */ (function () {
    function Config() {
    }
    // url of the chat server
    // for local development it will be something like http://192.168.0.214:9000/
    Config.server = 'https://api-provisional.herokuapp.com';
    Config.entityNames = ['secteur', 'pointvente', 'produit', 'rendezvous', 'commende'];
    Config.googleApiKey = "AIzaSyBNIN0oMzHoNgEZz1utnM_8ut6KFjwieoo";
    return Config;
}());

//# sourceMappingURL=config.js.map

/***/ }),

/***/ 486:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return DirectivesModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__lastcommende_lastcommende__ = __webpack_require__(801);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__lastrendevous_lastrendevous__ = __webpack_require__(802);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



var DirectivesModule = /** @class */ (function () {
    function DirectivesModule() {
    }
    DirectivesModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [__WEBPACK_IMPORTED_MODULE_1__lastcommende_lastcommende__["a" /* LastcommendeDirective */],
                __WEBPACK_IMPORTED_MODULE_2__lastrendevous_lastrendevous__["a" /* LastrendevousDirective */]],
            imports: [],
            exports: [__WEBPACK_IMPORTED_MODULE_1__lastcommende_lastcommende__["a" /* LastcommendeDirective */],
                __WEBPACK_IMPORTED_MODULE_2__lastrendevous_lastrendevous__["a" /* LastrendevousDirective */]]
        })
    ], DirectivesModule);
    return DirectivesModule;
}());

//# sourceMappingURL=directives.module.js.map

/***/ }),

/***/ 487:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_platform_browser_dynamic__ = __webpack_require__(488);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__app_module__ = __webpack_require__(492);


Object(__WEBPACK_IMPORTED_MODULE_0__angular_platform_browser_dynamic__["a" /* platformBrowserDynamic */])().bootstrapModule(__WEBPACK_IMPORTED_MODULE_1__app_module__["a" /* AppModule */]);
//# sourceMappingURL=main.js.map

/***/ }),

/***/ 492:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return AppModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_platform_browser__ = __webpack_require__(39);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__ionic_native_splash_screen__ = __webpack_require__(479);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__ionic_native_status_bar__ = __webpack_require__(480);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__app_notify__ = __webpack_require__(482);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__app_component__ = __webpack_require__(820);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__providers_manager_manager__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__angular_http__ = __webpack_require__(153);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__ionic_storage__ = __webpack_require__(88);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__providers_user_user__ = __webpack_require__(152);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11__ionic_native_firebase_ngx__ = __webpack_require__(348);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_12__ionic_native_geofence__ = __webpack_require__(481);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_13__ionic_native_geolocation__ = __webpack_require__(214);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_14__ionic_native_diagnostic__ = __webpack_require__(218);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_15__ionic_native_location_accuracy__ = __webpack_require__(219);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_16__providers_localisation_localisation__ = __webpack_require__(483);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_17__ionic_native_network__ = __webpack_require__(220);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_18__pipes_pipes_module__ = __webpack_require__(484);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_19__directives_directives_module__ = __webpack_require__(486);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_20__ionic_native_google_maps__ = __webpack_require__(821);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};





















var AppModule = /** @class */ (function () {
    function AppModule() {
    }
    AppModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_1__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_6__app_component__["a" /* MyApp */]
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_0__angular_platform_browser__["BrowserModule"],
                __WEBPACK_IMPORTED_MODULE_9__ionic_storage__["a" /* IonicStorageModule */].forRoot(),
                __WEBPACK_IMPORTED_MODULE_2_ionic_angular__["h" /* IonicModule */].forRoot(__WEBPACK_IMPORTED_MODULE_6__app_component__["a" /* MyApp */], {
                    tabsHideOnSubPages: true
                }, {
                    links: [
                        { loadChildren: '../pages/about/about.module#AboutPageModule', name: 'AboutPage', segment: 'about', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/cartograph/cartograph.module#CartographPageModule', name: 'CartographPage', segment: 'cartograph', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/commende-create/commende-create.module#CommendeCreatePageModule', name: 'CommendeCreatePage', segment: 'commende-create', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/commendes-view/commendes-view.module#CommendesViewPageModule', name: 'CommendesViewPage', segment: 'commendes-view', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/commendes/commendes.module#CommendesPageModule', name: 'CommendesPage', segment: 'commendes', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/createligne/createligne.module#CreatelignePageModule', name: 'CreatelignePage', segment: 'createligne', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/donnees/donnees.module#DonneesPageModule', name: 'DonneesPage', segment: 'donnees', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/filtre-pointvente/filtre-pointvente.module#FiltrePointventePageModule', name: 'FiltrePointventePage', segment: 'filtre-pointvente', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/filtre-stats/filtre-stats.module#FiltreStatsPageModule', name: 'FiltreStatsPage', segment: 'filtre-stats', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/filtre-vente/filtre-vente.module#FiltreVentePageModule', name: 'FiltreVentePage', segment: 'filtre-vente', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/help/help.module#HelpPageModule', name: 'HelpPage', segment: 'help', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/home/home.module#HomePageModule', name: 'HomePage', segment: 'home', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/map/map.module#MapPageModule', name: 'MapPage', segment: 'map', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/menu/menu.module#MenuPageModule', name: 'MenuPage', segment: 'menu', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/point-vente-detail/point-vente-detail.module#PointVenteDetailPageModule', name: 'PointVenteDetailPage', segment: 'point-vente-detail', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/point-vente/point-vente.module#PointVentePageModule', name: 'PointVentePage', segment: 'point-vente', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/pointventes/pointventes.module#PointventesPageModule', name: 'PointventesPage', segment: 'pointventes', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/pop-over-menu/pop-over-menu.module#PopOverMenuPageModule', name: 'PopOverMenuPage', segment: 'pop-over-menu', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/previsions/previsions.module#PrevisionsPageModule', name: 'PrevisionsPage', segment: 'previsions', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/price-detail/price-detail.module#PriceDetailPageModule', name: 'PriceDetailPage', segment: 'price-detail', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/produit-detail/produit-detail.module#ProduitDetailPageModule', name: 'ProduitDetailPage', segment: 'produit-detail', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/produit/produit.module#ProduitPageModule', name: 'ProduitPage', segment: 'produit', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/produits/produits.module#ProduitsPageModule', name: 'ProduitsPage', segment: 'produits', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/profile/profile.module#ProfilePageModule', name: 'ProfilePage', segment: 'profile', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/quartiers/quartiers.module#QuartiersPageModule', name: 'QuartiersPage', segment: 'quartiers', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/rapports/rapports.module#RapportsPageModule', name: 'RapportsPage', segment: 'rapports', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/rendezvous/rendezvous.module#RendezvousPageModule', name: 'RendezvousPage', segment: 'rendezvous', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/requests/requests.module#RequestsPageModule', name: 'RequestsPage', segment: 'requests', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/secteur/secteur.module#SecteurPageModule', name: 'SecteurPage', segment: 'secteur', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/secteurs/secteurs.module#SecteursPageModule', name: 'SecteursPage', segment: 'secteurs', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/selectclient/selectclient.module#SelectclientPageModule', name: 'SelectclientPage', segment: 'selectclient', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/selectproduit/selectproduit.module#SelectproduitPageModule', name: 'SelectproduitPage', segment: 'selectproduit', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/shoul-pay/shoul-pay.module#ShoulPayPageModule', name: 'ShoulPayPage', segment: 'shoul-pay', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/signup/signup.module#SignupPageModule', name: 'SignupPage', segment: 'signup', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/stats/stats.module#StatsPageModule', name: 'StatsPage', segment: 'stats', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/tabs/tabs.module#TabsPageModule', name: 'TabsPage', segment: 'tabs', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/unavailable/unavailable.module#UnavailablePageModule', name: 'UnavailablePage', segment: 'unavailable', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/vendeur/vendeur.module#VendeurPageModule', name: 'VendeurPage', segment: 'vendeur', priority: 'low', defaultHistory: [] },
                        { loadChildren: '../pages/vendeurs/vendeurs.module#VendeursPageModule', name: 'VendeursPage', segment: 'vendeurs', priority: 'low', defaultHistory: [] }
                    ]
                }),
                __WEBPACK_IMPORTED_MODULE_8__angular_http__["c" /* HttpModule */],
                __WEBPACK_IMPORTED_MODULE_18__pipes_pipes_module__["a" /* PipesModule */],
                __WEBPACK_IMPORTED_MODULE_19__directives_directives_module__["a" /* DirectivesModule */]
            ],
            bootstrap: [__WEBPACK_IMPORTED_MODULE_2_ionic_angular__["f" /* IonicApp */]],
            entryComponents: [
                __WEBPACK_IMPORTED_MODULE_6__app_component__["a" /* MyApp */]
            ],
            providers: [
                __WEBPACK_IMPORTED_MODULE_4__ionic_native_status_bar__["a" /* StatusBar */],
                __WEBPACK_IMPORTED_MODULE_3__ionic_native_splash_screen__["a" /* SplashScreen */],
                __WEBPACK_IMPORTED_MODULE_14__ionic_native_diagnostic__["a" /* Diagnostic */],
                __WEBPACK_IMPORTED_MODULE_12__ionic_native_geofence__["a" /* Geofence */],
                __WEBPACK_IMPORTED_MODULE_13__ionic_native_geolocation__["a" /* Geolocation */],
                __WEBPACK_IMPORTED_MODULE_15__ionic_native_location_accuracy__["a" /* LocationAccuracy */],
                __WEBPACK_IMPORTED_MODULE_20__ionic_native_google_maps__["a" /* GoogleMaps */],
                { provide: __WEBPACK_IMPORTED_MODULE_1__angular_core__["ErrorHandler"], useClass: __WEBPACK_IMPORTED_MODULE_2_ionic_angular__["g" /* IonicErrorHandler */] },
                __WEBPACK_IMPORTED_MODULE_7__providers_manager_manager__["a" /* ManagerProvider */],
                __WEBPACK_IMPORTED_MODULE_5__app_notify__["a" /* AppNotify */],
                __WEBPACK_IMPORTED_MODULE_16__providers_localisation_localisation__["a" /* LocalisationProvider */],
                __WEBPACK_IMPORTED_MODULE_10__providers_user_user__["a" /* UserProvider */],
                __WEBPACK_IMPORTED_MODULE_17__ionic_native_network__["a" /* Network */],
                __WEBPACK_IMPORTED_MODULE_11__ionic_native_firebase_ngx__["a" /* Firebase */]
            ]
        })
    ], AppModule);
    return AppModule;
}());

//# sourceMappingURL=app.module.js.map

/***/ }),

/***/ 522:
/***/ (function(module, exports, __webpack_require__) {

var map = {
	"./af": 221,
	"./af.js": 221,
	"./ar": 222,
	"./ar-dz": 223,
	"./ar-dz.js": 223,
	"./ar-kw": 224,
	"./ar-kw.js": 224,
	"./ar-ly": 225,
	"./ar-ly.js": 225,
	"./ar-ma": 226,
	"./ar-ma.js": 226,
	"./ar-sa": 227,
	"./ar-sa.js": 227,
	"./ar-tn": 228,
	"./ar-tn.js": 228,
	"./ar.js": 222,
	"./az": 229,
	"./az.js": 229,
	"./be": 230,
	"./be.js": 230,
	"./bg": 231,
	"./bg.js": 231,
	"./bm": 232,
	"./bm.js": 232,
	"./bn": 233,
	"./bn.js": 233,
	"./bo": 234,
	"./bo.js": 234,
	"./br": 235,
	"./br.js": 235,
	"./bs": 236,
	"./bs.js": 236,
	"./ca": 237,
	"./ca.js": 237,
	"./cs": 238,
	"./cs.js": 238,
	"./cv": 239,
	"./cv.js": 239,
	"./cy": 240,
	"./cy.js": 240,
	"./da": 241,
	"./da.js": 241,
	"./de": 242,
	"./de-at": 243,
	"./de-at.js": 243,
	"./de-ch": 244,
	"./de-ch.js": 244,
	"./de.js": 242,
	"./dv": 245,
	"./dv.js": 245,
	"./el": 246,
	"./el.js": 246,
	"./en-SG": 247,
	"./en-SG.js": 247,
	"./en-au": 248,
	"./en-au.js": 248,
	"./en-ca": 249,
	"./en-ca.js": 249,
	"./en-gb": 250,
	"./en-gb.js": 250,
	"./en-ie": 251,
	"./en-ie.js": 251,
	"./en-il": 252,
	"./en-il.js": 252,
	"./en-nz": 253,
	"./en-nz.js": 253,
	"./eo": 254,
	"./eo.js": 254,
	"./es": 255,
	"./es-do": 256,
	"./es-do.js": 256,
	"./es-us": 257,
	"./es-us.js": 257,
	"./es.js": 255,
	"./et": 258,
	"./et.js": 258,
	"./eu": 259,
	"./eu.js": 259,
	"./fa": 260,
	"./fa.js": 260,
	"./fi": 261,
	"./fi.js": 261,
	"./fo": 262,
	"./fo.js": 262,
	"./fr": 263,
	"./fr-ca": 264,
	"./fr-ca.js": 264,
	"./fr-ch": 265,
	"./fr-ch.js": 265,
	"./fr.js": 263,
	"./fy": 266,
	"./fy.js": 266,
	"./ga": 267,
	"./ga.js": 267,
	"./gd": 268,
	"./gd.js": 268,
	"./gl": 269,
	"./gl.js": 269,
	"./gom-latn": 270,
	"./gom-latn.js": 270,
	"./gu": 271,
	"./gu.js": 271,
	"./he": 272,
	"./he.js": 272,
	"./hi": 273,
	"./hi.js": 273,
	"./hr": 274,
	"./hr.js": 274,
	"./hu": 275,
	"./hu.js": 275,
	"./hy-am": 276,
	"./hy-am.js": 276,
	"./id": 277,
	"./id.js": 277,
	"./is": 278,
	"./is.js": 278,
	"./it": 279,
	"./it-ch": 280,
	"./it-ch.js": 280,
	"./it.js": 279,
	"./ja": 281,
	"./ja.js": 281,
	"./jv": 282,
	"./jv.js": 282,
	"./ka": 283,
	"./ka.js": 283,
	"./kk": 284,
	"./kk.js": 284,
	"./km": 285,
	"./km.js": 285,
	"./kn": 286,
	"./kn.js": 286,
	"./ko": 287,
	"./ko.js": 287,
	"./ku": 288,
	"./ku.js": 288,
	"./ky": 289,
	"./ky.js": 289,
	"./lb": 290,
	"./lb.js": 290,
	"./lo": 291,
	"./lo.js": 291,
	"./lt": 292,
	"./lt.js": 292,
	"./lv": 293,
	"./lv.js": 293,
	"./me": 294,
	"./me.js": 294,
	"./mi": 295,
	"./mi.js": 295,
	"./mk": 296,
	"./mk.js": 296,
	"./ml": 297,
	"./ml.js": 297,
	"./mn": 298,
	"./mn.js": 298,
	"./mr": 299,
	"./mr.js": 299,
	"./ms": 300,
	"./ms-my": 301,
	"./ms-my.js": 301,
	"./ms.js": 300,
	"./mt": 302,
	"./mt.js": 302,
	"./my": 303,
	"./my.js": 303,
	"./nb": 304,
	"./nb.js": 304,
	"./ne": 305,
	"./ne.js": 305,
	"./nl": 306,
	"./nl-be": 307,
	"./nl-be.js": 307,
	"./nl.js": 306,
	"./nn": 308,
	"./nn.js": 308,
	"./pa-in": 309,
	"./pa-in.js": 309,
	"./pl": 310,
	"./pl.js": 310,
	"./pt": 311,
	"./pt-br": 312,
	"./pt-br.js": 312,
	"./pt.js": 311,
	"./ro": 313,
	"./ro.js": 313,
	"./ru": 314,
	"./ru.js": 314,
	"./sd": 315,
	"./sd.js": 315,
	"./se": 316,
	"./se.js": 316,
	"./si": 317,
	"./si.js": 317,
	"./sk": 318,
	"./sk.js": 318,
	"./sl": 319,
	"./sl.js": 319,
	"./sq": 320,
	"./sq.js": 320,
	"./sr": 321,
	"./sr-cyrl": 322,
	"./sr-cyrl.js": 322,
	"./sr.js": 321,
	"./ss": 323,
	"./ss.js": 323,
	"./sv": 324,
	"./sv.js": 324,
	"./sw": 325,
	"./sw.js": 325,
	"./ta": 326,
	"./ta.js": 326,
	"./te": 327,
	"./te.js": 327,
	"./tet": 328,
	"./tet.js": 328,
	"./tg": 329,
	"./tg.js": 329,
	"./th": 330,
	"./th.js": 330,
	"./tl-ph": 331,
	"./tl-ph.js": 331,
	"./tlh": 332,
	"./tlh.js": 332,
	"./tr": 333,
	"./tr.js": 333,
	"./tzl": 334,
	"./tzl.js": 334,
	"./tzm": 335,
	"./tzm-latn": 336,
	"./tzm-latn.js": 336,
	"./tzm.js": 335,
	"./ug-cn": 337,
	"./ug-cn.js": 337,
	"./uk": 338,
	"./uk.js": 338,
	"./ur": 339,
	"./ur.js": 339,
	"./uz": 340,
	"./uz-latn": 341,
	"./uz-latn.js": 341,
	"./uz.js": 340,
	"./vi": 342,
	"./vi.js": 342,
	"./x-pseudo": 343,
	"./x-pseudo.js": 343,
	"./yo": 344,
	"./yo.js": 344,
	"./zh-cn": 345,
	"./zh-cn.js": 345,
	"./zh-hk": 346,
	"./zh-hk.js": 346,
	"./zh-tw": 347,
	"./zh-tw.js": 347
};
function webpackContext(req) {
	return __webpack_require__(webpackContextResolve(req));
};
function webpackContextResolve(req) {
	var id = map[req];
	if(!(id + 1)) // check for number or string
		throw new Error("Cannot find module '" + req + "'.");
	return id;
};
webpackContext.keys = function webpackContextKeys() {
	return Object.keys(map);
};
webpackContext.resolve = webpackContextResolve;
module.exports = webpackContext;
webpackContext.id = 522;

/***/ }),

/***/ 800:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MomentPipe; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_moment__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_moment___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_moment__);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};


/**
 * Generated class for the MomentPipe pipe.
 *
 * See https://angular.io/api/core/Pipe for more info on Angular Pipes.
 */
var MomentPipe = /** @class */ (function () {
    function MomentPipe() {
    }
    /**
     * Takes a value and makes it lowercase.
     */
    MomentPipe.prototype.transform = function (date, method) {
        if (!method)
            return this.fromNow(date);
        return __WEBPACK_IMPORTED_MODULE_1_moment__(date).fromNow();
    };
    MomentPipe.prototype.fromNow = function (date) {
        return __WEBPACK_IMPORTED_MODULE_1_moment__(date).calendar();
    };
    MomentPipe = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Pipe"])({
            name: 'moment',
        })
    ], MomentPipe);
    return MomentPipe;
}());

//# sourceMappingURL=moment.js.map

/***/ }),

/***/ 801:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return LastcommendeDirective; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__providers_manager_manager__ = __webpack_require__(47);
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
 * Generated class for the LastcommendeDirective directive.
 *
 * See https://angular.io/api/core/Directive for more info on Angular
 * Directives.
 */
var LastcommendeDirective = /** @class */ (function () {
    function LastcommendeDirective(manager) {
        this.manager = manager;
    }
    LastcommendeDirective.prototype.ngOnInit = function () {
        var _this = this;
        if (!this.pointvente || !this.pointvente.lastCommende)
            return;
        console.log('Hello LastcommendeDirective Directive');
        this.pointvente.lastCommende.loading = true;
        this.manager.show('commende', this.pointvente.lastCommende.id).then(function (data) {
            if (data)
                _this.pointvente.lastCommende = data;
            console.log(data);
        });
    };
    LastcommendeDirective.prototype.ngOnChanges = function () {
        this.ngOnInit();
    };
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"])(),
        __metadata("design:type", Object)
    ], LastcommendeDirective.prototype, "pointvente", void 0);
    LastcommendeDirective = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"])({
            selector: '[lastcommende]' // Attribute selector
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1__providers_manager_manager__["a" /* ManagerProvider */]])
    ], LastcommendeDirective);
    return LastcommendeDirective;
}());

//# sourceMappingURL=lastcommende.js.map

/***/ }),

/***/ 802:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return LastrendevousDirective; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__providers_manager_manager__ = __webpack_require__(47);
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
 * Generated class for the LastrendevousDirective directive.
 *
 * See https://angular.io/api/core/Directive for more info on Angular
 * Directives.
 */
var LastrendevousDirective = /** @class */ (function () {
    function LastrendevousDirective(manager) {
        this.manager = manager;
    }
    LastrendevousDirective.prototype.ngOnInit = function () {
        var _this = this;
        if (!this.pointvente || !this.pointvente.rendezvous)
            return;
        this.pointvente.rendezvous.loading = true;
        this.manager.show('rendezvous', this.pointvente.id, true).then(function (data) {
            if (data)
                _this.pointvente.rendezvous = data;
            console.log(data);
        });
    };
    LastrendevousDirective.prototype.ngOnChanges = function () {
        this.ngOnInit();
    };
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"])(),
        __metadata("design:type", Object)
    ], LastrendevousDirective.prototype, "pointvente", void 0);
    LastrendevousDirective = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"])({
            selector: '[lastrendevous]' // Attribute selector
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1__providers_manager_manager__["a" /* ManagerProvider */]])
    ], LastrendevousDirective);
    return LastrendevousDirective;
}());

//# sourceMappingURL=lastrendevous.js.map

/***/ }),

/***/ 820:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MyApp; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__ionic_native_status_bar__ = __webpack_require__(480);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__ionic_native_splash_screen__ = __webpack_require__(479);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__providers_user_user__ = __webpack_require__(152);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_moment__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_moment___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5_moment__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__providers_manager_manager__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__ionic_native_geofence__ = __webpack_require__(481);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};








var MyApp = /** @class */ (function () {
    function MyApp(platform, statusBar, splashScreen, geofence, events, manager, userService) {
        var _this = this;
        this.geofence = geofence;
        this.events = events;
        this.manager = manager;
        this.userService = userService;
        this.rootPage = 'MenuPage';
        this.setMomentConfig();
        platform.ready().then(function () {
            if (platform.is('cordova')) {
                /* this.userService.getToken();
                 this.userService.onNotification();
                 this.geofence.initialize().then(
                   () => this.addGeofence(),
                   (err) => console.log(err)
                 )
                 this.geofence.onTransitionReceived().subscribe(data => {
                      console.log(data) /// sent t the server
                 })*/
            }
            _this.events.subscribe('app:connection:change', function (status) {
                if (status == 'connected') {
                    _this.manager.connected = true;
                    _this.manager.isAscing = true;
                    _this.manager.ascync().then(function () {
                        _this.manager.isAscing = false;
                    });
                }
            });
            /* this.userService.getAuthenticatedUser().subscribe(user => {
               if (user)
                 this.events.publish('app:connection:change', 'connected');
             })
             */
            statusBar.styleDefault();
            splashScreen.hide();
        });
    }
    MyApp.prototype.addGeofence = function () {
        var _this = this;
        this.userService.getAuthenticatedUser().subscribe(function (user) {
            if (user && user.secteur) {
                var fence = {
                    id: user.secteur.id,
                    latitude: user.secteur.lat,
                    longitude: user.secteur.long,
                    radius: user.secteur.radius,
                    transitionType: 3,
                    notification: {
                        id: 1,
                        title: 'Changement de zone',
                        text: 'Vous venez de changer de zone.',
                        openAppOnClick: true //open app when notification is tapped
                    }
                };
                _this.geofence.addOrUpdate(fence).then(function () { return console.log('Geofence added'); }, function (err) { return console.log('Geofence failed to add'); });
            }
        });
    };
    MyApp.prototype.setMomentConfig = function () {
        __WEBPACK_IMPORTED_MODULE_5_moment__["locale"]('fr', {
            months: 'janvier_février_mars_avril_mai_juin_juillet_août_septembre_octobre_novembre_décembre'.split('_'),
            monthsShort: 'janv._févr._mars_avr._mai_juin_juil._août_sept._oct._nov._déc.'.split('_'),
            monthsParseExact: true,
            weekdays: 'dimanche_lundi_mardi_mercredi_jeudi_vendredi_samedi'.split('_'),
            weekdaysShort: 'dim._lun._mar._mer._jeu._ven._sam.'.split('_'),
            weekdaysMin: 'Di_Lu_Ma_Me_Je_Ve_Sa'.split('_'),
            weekdaysParseExact: true,
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'HH:mm:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY HH:mm',
                LLLL: 'dddd D MMMM YYYY HH:mm'
            },
            calendar: {
                sameDay: '[Aujourd’hui]',
                nextDay: '[Demain]',
                nextWeek: 'dddd [prochain]',
                lastDay: '[Hier]',
                lastWeek: 'dddd [dernier]',
                sameElse: '[le] LL'
            },
            relativeTime: {
                future: 'dans %s',
                past: 'il y a %s',
                s: 'quelques secondes',
                m: 'une minute',
                mm: '%d minutes',
                h: 'une heure',
                hh: '%d heures',
                d: 'un jour',
                dd: '%d jours',
                M: 'un mois',
                MM: '%d mois',
                y: 'un an',
                yy: '%d ans'
            }
        });
    };
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["ViewChild"])(__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["m" /* Nav */]),
        __metadata("design:type", __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["m" /* Nav */])
    ], MyApp.prototype, "nav", void 0);
    MyApp = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\app\app.html"*/'<ion-nav [root]="rootPage"></ion-nav>\n'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\app\app.html"*/
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["p" /* Platform */],
            __WEBPACK_IMPORTED_MODULE_2__ionic_native_status_bar__["a" /* StatusBar */],
            __WEBPACK_IMPORTED_MODULE_3__ionic_native_splash_screen__["a" /* SplashScreen */],
            __WEBPACK_IMPORTED_MODULE_7__ionic_native_geofence__["a" /* Geofence */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["d" /* Events */],
            __WEBPACK_IMPORTED_MODULE_6__providers_manager_manager__["a" /* ManagerProvider */],
            __WEBPACK_IMPORTED_MODULE_4__providers_user_user__["a" /* UserProvider */]])
    ], MyApp);
    return MyApp;
}());

//# sourceMappingURL=app.component.js.map

/***/ })

},[487]);
//# sourceMappingURL=main.js.map