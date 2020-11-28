export default {

    modify(user, model) {
        return user.id === model.user_id; //Returns either true or false
    },

    accept(user, answer) {
        return user.id === answer.question.user_id; //Returns either true or false
    }

}
