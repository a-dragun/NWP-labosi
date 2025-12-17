const mongoose = require('mongoose');

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
  teamMembers: [String]
});


module.exports = mongoose.model('Project', ProjectSchema);
