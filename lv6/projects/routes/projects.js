const express = require('express');
const router = express.Router();
const Project = require('../models/Project');

router.get('/', async (req, res) => {
  const projects = await Project.find();
  res.render('projects/index', { projects });
});

router.get('/create', (req, res) => {
  res.render('projects/create');
});

router.post('/', async (req, res) => {
  await Project.create(req.body);
  res.redirect('/projects');
});

router.get('/:id/edit', async (req, res) => {
  try {
    const project = await Project.findById(req.params.id);
    if (!project) return res.status(404).send('Project not found');
    res.render('projects/edit', { project });
  } catch(err) {
    res.status(500).send(err.message);
  }
});

router.post('/:id', async (req, res) => {
  try {
    const { teamMembers, ...rest } = req.body;
    if (teamMembers) {
      rest.teamMembers = teamMembers.split(',').map(m => m.trim()).filter(m => m !== '');
    }
    await Project.findByIdAndUpdate(req.params.id, rest, { runValidators: true });
    res.redirect('/projects');
  } catch(err) {
    const project = await Project.findById(req.params.id);
    res.render('projects/edit', { project, error: err.message });
  }
});


router.post('/:id/delete', async (req, res) => {
  try {
    await Project.findByIdAndDelete(req.params.id);
    res.redirect('/projects');
  } catch(err) {
    res.status(500).send(err.message);
  }
});

module.exports = router;
