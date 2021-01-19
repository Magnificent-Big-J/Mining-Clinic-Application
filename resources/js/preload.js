// Js that must be loaded before any other js runs

import addAppData from './helpers/AppData';
import addRoutes from './helpers/Routes';

global.addAppData = addAppData;
global.addRoutes = addRoutes;
