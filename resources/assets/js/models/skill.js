(function () {
    this.Skills = function () {
        Collection.call(this);
    }
    Skills.prototype = Object.create(Collection.prototype);
    Skills.prototype.constructor = Skills;
    Skills.prototype.model = function(attributes) {
        return new Skill(attributes);
    }
    Skills.prototype.all = function(success, error) {
        this.list('/api/skill/list', success, error);
    }
}());

(function () {
    this.Skill = function (attributes) {
        Model.call(this);
        this.attributes = {};
        this.oldAttributes = {};
        this.setAttributes(attributes);
    }
    Skill.prototype = Object.create(Model.prototype);
    Skill.prototype.constructor = Skill;
}());

window.skills = function () {
    return new Skills();
};