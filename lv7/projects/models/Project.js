const mongoose = require('mongoose');
const User = require('./User');

const ProjectSchema = new mongoose.Schema({
  name: { type: String, required: true },
  description: String,
  price: {
    type: Number, 
    validate: {
      validator: function(value) {
        return value >= 0;
      },
      message: 'Price has to be more than 0'
    }
  },
  completedWork: String,
  startDate: Date,
  endDate: {
    type: Date,
    validate: {
      validator: function(value) {
        if (!this.startDate || !value) return true;
        return value >= this.startDate;
      },
      message: 'End date cannot be before start date'
    }
  },
  teamMembers: [{ type: mongoose.Schema.Types.ObjectId, ref: 'User' }],
  owner: { type: mongoose.Schema.Types.ObjectId, ref: 'User', required: true },
  archived: { type: Boolean, default: false }
});


module.exports = mongoose.model('Project', ProjectSchema);
