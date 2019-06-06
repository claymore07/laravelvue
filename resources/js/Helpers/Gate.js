import AppStorage from './AppStorage'
export default class Gate{
    constructor(){
        this.user = AppStorage.getUserDetail();
    }
    hasProfile(){
        return this.user.hasProfile;
    }
    isAdmin(){
        return this.user.type === 'admin';
    }
    isUser(){
        return this.user.type === 'user'
    }
    isAuthor(){
        return this.user.type === 'author'
    }
    isAuthorOrUser(){
        if(this.user.type === 'user' || this.user.type === 'author'){
            return true;
        }

    }
    isAdminOrUser(){
        if(this.user.type === 'user' || this.user.type === 'admin'){
            return true;
        }

    }
}
