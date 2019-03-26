class AppStorage {
    storeToken(token){
        return localStorage.setItem('token', token);
    }
    storeUser(username){
        localStorage.setItem('user', username);
    }
    storeUserDetail(userDetail){
        localStorage.setItem('userDetail', JSON.stringify(userDetail));
    }
    store(username,userDetail, token){
        this.storeToken(token);
        this.storeUser(username);
        this.storeUserDetail(userDetail);
    }

    clear(){
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        localStorage.removeItem('userDetail');
    }

    getToken(){
        return localStorage.getItem('token')
    }

    getUser(){
        return localStorage.getItem('user');
    }
    getUserDetail(){
        return JSON.parse(localStorage.getItem('userDetail'));;
    }
}

export default AppStorage = new AppStorage()
