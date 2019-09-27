import Token from './Token'
import AppStorage from './AppStorage'
class User{
    login(form){
        form.post('/api/auth/login')
            .then(res => {
                this.responseAfterLogin(res)
            }).catch(error => {
                if((error.response.status == 406)){
                    window.swal.fire({
                        title: 'توجه',
                        type: 'info',
                        confirmButtonText: 'متوجه شدم!',
                        text: `${error.response.data.error}`,
                    })
                }else{
                    window.swal.fire({
                        title: 'خطا!',
                        type: 'error',
                        confirmButtonText: 'متوجه شدم!',
                        text: `اطلاعات ورودی دارای خطا می باشد، لطفا مجددا بررسی کنید.`,
                    })
                }
        })
    }
    responseAfterLogin(res){
        const access_token = res.data.access_token;
        const username = res.data.user.name ;
        const userDetail = res.data.user;

        if(Token.isValid(access_token)){
            AppStorage.store(username, userDetail, access_token);
            if(AppStorage.getUserDetail().hasProfile){
                window.location = '/home';
            }else{
                window.location = '/profile';
            }
            console.log('isvalid')
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
       // console.log('logged');
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
            const storedToken = AppStorage.getToken();
            return Token.payload(storedToken).type;
        }
    }
    lastSeen(){
        if(this.loggedIn()){
            return AppStorage.getUserDetail().last_login;
        }
    }
    IPAddress(){
        if(this.loggedIn()){
            return AppStorage.getUserDetail().ip_address;
        }
    }
    hasProfile(){
        if(this.loggedIn()){
            return AppStorage.getUserDetail().hasProfile;
        }
    }
    photo(){
        if(this.loggedIn()){
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
