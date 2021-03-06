import Api from '_shared/Api'

export default class ApiSkill {

    static assignSkillToFormData( skill ) {
        var formData = new FormData();
    
        formData = Api.appendFormData(formData, 'name', skill.name);
        formData = Api.appendFormData(formData, 'explainer', skill.explainer);
        formData = Api.appendFormData(formData, 'fixedCase', skill.fixedCase);
        formData = Api.appendFormData(formData, 'categoryId', skill.categoryId);
        formData = Api.appendFormData(formData, 'type', skill.type);

        return formData;

    }

    static getSkills( loggedIn ) {
        return Api.get("/auth/skills", undefined, Api.getTokenFrom( loggedIn ))
    }

    static insertSkill( skill, loggedIn ) {
        return Api.post("/auth/skills", this.assignSkillToFormData( skill ), Api.getTokenFrom( loggedIn ) )
    }

    static updateSkill( skill, loggedIn ) {
        return Api.put("/auth/skills/" + skill.id,this.assignSkillToFormData( skill ), Api.getTokenFrom( loggedIn )  )
    }

    static deleteSkill( skill, loggedIn ) {
        return Api.delete("/auth/skills/" + skill.id, Api.getTokenFrom( loggedIn ) );
    }
    
}