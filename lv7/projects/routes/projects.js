const express = require('express');
const router = express.Router();
const Project = require('../models/Project');
const User = require('../models/User');
const isAuth = require('../middleware/auth');


router.get('/', isAuth, async (req, res) => {
  const userId = req.session.userId;
  const ownerProjects = await Project.find({ owner: userId }).populate('owner').populate('teamMembers');
  const memberProjects = await Project.find({ teamMembers: userId }).populate('owner').populate('teamMembers');
  res.render('projects/index', { ownerProjects, memberProjects });
});

router.get('/create', isAuth, async (req, res) => {
  let users = await User.find();
  const currentUserId = req.session.userId.toString();
  users = users.filter(u => u._id.toString() !== currentUserId);
  res.render('projects/create', { users });
});

router.post('/', isAuth, async (req, res) => {
  try {
    const { teamMembers, ...rest } = req.body;
    let members = [];
    if (teamMembers) {
      members = Array.isArray(teamMembers) ? teamMembers : [teamMembers];
    }
    await Project.create({ ...rest, owner: req.session.userId, teamMembers: members });
    res.redirect('/projects');
  } catch(err) {
    res.status(500).send(err.message);
  }
});

router.get('/:id/edit', isAuth, async (req, res) => {
  const project = await Project.findById(req.params.id).populate('teamMembers');
  if (!project) return res.status(404).send('Project not found');
  let users = await User.find();
  const currentUserId = req.session.userId.toString();
  users = users.filter(u => u._id.toString() !== currentUserId);
  const isOwner = project.owner.toString() === currentUserId;
  res.render('projects/edit', { project, users, isOwner });
});

router.post('/:id', isAuth, async (req, res) => {
  const project = await Project.findById(req.params.id);
  if (!project) return res.status(404).send('Project not found');

  const currentUserId = req.session.userId.toString();
  const isOwner = project.owner.toString() === currentUserId;

  let updateData = {};
  if (isOwner) {
    const { teamMembers, archived, ...rest } = req.body;
    let members = [];
    if (teamMembers) members = Array.isArray(teamMembers) ? teamMembers : [teamMembers];
    const isArchived = archived === 'true';
    updateData = { ...rest, teamMembers: members, archived: isArchived };
  } else if (project.teamMembers.includes(currentUserId)) {
    updateData = { completedWork: req.body.completedWork };
  } else {
    return res.status(403).send('You cannot edit this project');
  }

  await Project.findByIdAndUpdate(req.params.id, updateData, { runValidators: true });
  res.redirect('/projects');
});


router.post('/:id/delete', isAuth, async (req, res) => {
  const project = await Project.findById(req.params.id);
  if (!project) return res.status(404).send('Project not found');
  if (project.owner.toString() !== req.session.userId) {
    return res.status(403).send('You are not allowed to delete this project');
  }
  await Project.findByIdAndDelete(req.params.id);
  res.redirect('/projects');
});

module.exports = router;
