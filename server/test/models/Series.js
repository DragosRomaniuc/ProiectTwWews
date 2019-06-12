const mongoose = require('mongoose');

const MovieSchema = new mongoose.Schema({
    name: { type: String, required: true},
    description: { type: String, required: true},
    createdAd: { type: Date, default: Date.now}
})

const Movie = mongoose.model('Movies', MovieSchema);
module.exports = Movie;