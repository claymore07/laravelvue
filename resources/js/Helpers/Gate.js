import AppStorage from './AppStorage'
import Token from './Token'
export default class Gate{
    constructor(){
        const storedToken = AppStorage.getToken();
        if(storedToken){
            this.type =  Token.payload(storedToken).type;
        }
        this.user = AppStorage.getUserDetail();
    }
    hasProfile(){
        return this.user.hasProfile;
    }
    isAdmin(){
        return this.type === 'admin';
    }
    isUser(){
        return this.type === 'user'
    }
    isAuthor(){
        return this.type === 'author'
    }
    isAuthorOrUser(){
        if(this.type === 'user' || this.type === 'author'){
            return true;
        }
    }
    isAdminOrUser(){
        if(this.type === 'user' || this.type === 'admin'){
            return true;
        }

    }
    isAdminOrAuthor(){
        if(this.type === 'author' || this.type === 'admin'){
            return true;
        }else {
            return false;
        }
    }
}
