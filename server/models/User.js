const mongoose = require('mongoose');

const UserSchema = new mongoose.Schema({
    name: { type: String, required: true},
    news : [{type: mongoose.Schema.Types.ObjectId, ref: "News"}]
})

const User = mongoose.model('User', UserSchema);
module.exports = User;