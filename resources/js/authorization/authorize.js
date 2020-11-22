//Authorization functionality
import policies from "./policies";

export default {
    install (Vue, options){
        Vue.prototype.authorize = function (policy, model) { //Creates a prototyped function 'authorize' in Vue
            if(! window.Auth.signedIn) return false; //if user is not logged in
            // Makes sure the supplied policy is a string and the model
            // Is an object
            if(typeof policy === 'string' && typeof model == 'object'){
                const user = window.Auth.user; //assigning the logged in user to a variable

                return policies[policy](user, model);
            }
        };
        //Place the sign in variable in the vuejs prototype so that it can be accessible in all components
        Vue.prototype.signedIn = window.Auth.signedIn;
    }
}

