<?php
switch ($direction) {
    case $direction == 1:
      $fallDirection = 'Naar links gevallen';
      break;
    case $direction == 2:
      $fallDirection = 'Naar rechts gevallen';
      break;
    case $direction == 3:
      $fallDirection = 'Frontaal gevallen';
      break;
    case $direction == 4:
      $fallDirection = 'Achterwaarts gevallen';
      break;
    case $direction == 5:
      $fallDirection = 'Op zijn voeten gevallen';
      break;
    case $direction == 6:
      $fallDirection = 'Op zijn hoofd gevallen';
      break;
    
    default:
      $fallDirection = 'Geen val gedetecteerd';
  };
  echo json_encode($fallDirection);