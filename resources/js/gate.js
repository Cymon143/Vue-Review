export default class Gate{
    constructor(user,role){
        this.user = user;
        this.role = role;
    }
    current_log_in(){
        return this.user;
    }
}
