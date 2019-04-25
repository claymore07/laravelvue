import Token from './Token'
import AppStorage from './AppStorage'
class User{
    login(form){
        form.post('/api/auth/login')
            .then(res => {
                this.responseAfterLogin(res)
            }).catch(error => {
            this.errorSwal('اطلاعات وارد شده صحیح نمی باشد، لطفا مجددا بررسی کنید!')
        })
    }
    responseAfterLogin(res){
        const access_token = res.data.access_token;
        const username = res.data.user.name ;
        const userDetail = res.data.user;

        if(Token.isValid(access_token)){
            AppStorage.store(username, userDetail, access_token);
            window.location = '/home';
        }
    }
    hasToken(){
        const storedToken = AppStorage.getToken();
        if (storedToken ){
            return Token.isValid(storedToken) ? true : this.logout();
        }
        return false;
    }

    loggedIn(){
        console.log('logged');
        return this.hasToken();
    }
    forceLogOut(){
        if(!this.hasToken()){
            AppStorage.clear();
            window.location = '/login';
        }
    }

    logout(){
        AppStorage.clear();
        axios.post('/api/auth/logout')
            .then(res =>{
                window.location = '/login';
            }).catch(error =>{
                window.location = '/login';
            });
    }


    name(){
        if(this.loggedIn()){
            return AppStorage.getUser();
        }
    }
    type(){
        if(this.loggedIn()){
            return AppStorage.getUserDetail().type;
        }
    }
    lastSeen(){
        if(this.loggedIn()){
            return AppStorage.getUserDetail().updated_at;
        }
    }
    photo(){
        if(this.loggedIn()){
            console.log(AppStorage.getUserDetail().photo);
            return AppStorage.getUserDetail().photo;
        }
    }
    id(){
        if(this.loggedIn()){
            const payload = Token.payload(AppStorage.getToken());
            return payload.sub
        }
    }
    own(id) {
        return this.id() == id;
    }

    admin() {
        return this.id() == 18;
    }
}
export default User = new User()
