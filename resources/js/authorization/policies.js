export default {

    modify(user, model) {
        return user.id === model.user_id; //Returns either true or false
    },

    accept(user, answer) {
        return user.id === answer.question.user_id; //Returns either true or false
    },

    deleteQuestion(user, question) {
        return user.id === question.user_id && question.answers_count < 1; //Returns either true or false
    },

}
