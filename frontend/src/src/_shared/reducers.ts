import { combineReducers } from 'redux'
import postingReducer from 'posting/_store/red.posting'
import authReducer from 'auth/_store/red.auth'
import experienceReducer from 'experience/_store/red.experience';
import skillReducer from 'skill/_store/red.skill';
import skillCategoryReducer from 'skillCategory/_store/red.skillCategory';
import errorReducer from 'error/_store/red.error';



const rootReducer = combineReducers({
    posting : postingReducer,
    auth: authReducer,
    experience: experienceReducer,
    error: errorReducer,
    skill: skillReducer,
    skillCategory: skillCategoryReducer,
});

export type RootState = ReturnType<typeof rootReducer>;
export default rootReducer;