## StickEffect

[![](https://poggit.pmmp.io/shield.state/StickEffect)](https://poggit.pmmp.io/p/StickEffect)
[![](https://poggit.pmmp.io/shield.dl.total/StickEffect)](https://poggit.pmmp.io/p/StickEffect)

It is a plugin that allows to add effects by clicking on configure items


## Config.yml

````YAML
---
# DO NOT TOUCH !
version: 3.0

# Welcome to StickEffect version 1.0.0
# ---
# the {time} notation in the "message" element allows you to take the time of the remaining cooldown
# effect duration is for 20 = 1 second
# the effect level is for 0 = 1 level so level 1 is finally equal to 2
# the "visible" element allows to make appear or not the fantasy bubbles (true:false)
# l'élement "remove" allows to remove the stick at each use

"369:0":
  cooldown: 60 # secondes 
  message: "you have {time} seconds left to use the stick"
  remove: true
  permission:
    enable: false
    perm: 'stick.use'
    message_perm: "§cYou don’t have permission !"
  effect:
    1: # id effect (speed)
      duration: 20 # ticks, 20 = 20 secondes
      niveau: 1 = 1 lvl
      visible: false

"336:0":
  cooldown: 60
  message: "you have {time} seconds left to use the stick"
  remove: true
  permission:
    enable: true
    perm: 'stick2.use'
    message_perm: "§cYou don’t have permission !"
  effect:
    3: # id haste
      duration: 20
      niveau: 2
      visible: true
...
````

## API

The plugin also allows you to have a small API available. </br>

To get the API: 
````PHP
$api = $this->getServer()->getPluginManager()->getPlugin('StickEffect');
````

functions: 
````PHP
$array = $api->getAllStick(); // array
$stick = $api->getStickFromString('325:0'); // array
$effects = $api->getAllEffectFromStick('325:0'); // array
$perm = $api->hasPermInStick('325:0');  // bool
$permission = $api->getPermissionInStick('325:0'); // string
````
