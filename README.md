# text_based_game_engine
Simple game engine for RPG text-based game. 

### Intro
You can try API on the demo server: http://78.47.191.23/game/welcome

### Topics
#### To play game
* [Create new player](#create_new_player)  
* [Authentification](#authentication) 
* [Start the game](#start_the_game)
* [Questions](#questions)
* [Answers](#answer)
* [Triggers](#triggers)
* [Fight](#fight)
* [Inventory](#inventory)
* [Active Equipment Slots](#active_equipment_slots)
* [Load previous game](#load_game)

#### For developers
* [Installation](#installation)
* [How to make own quests. Typical scenarios](#own_quest)

REST API
-------------
<a name="create_new_player"/>
### Create new player
```
POST /user
```
```php
User[name]
User[username]
User[password]
User[password_repeat] 
```

Success Answer Example:
```json
{
  "success": true,
  "data": {
    "User": {
      "id": 2,
      "name": "Alex",
      "username": "alex",
      "health": 100,
      "max_health": 100,
      "damage": 10,
      "agility": 10,
      "level": 1,
      "experience": 0
    }
  }
}
```
Error Answer Example:
```json
{
  "success": false,
  "data": {
    "errors": {
      "password": [
        "Password should contain at least 5 characters."
      ],
      "password_repeat": [
        "Passwords don't match"
      ],
      "username": [
        "Username \"alex\" has already been taken."
      ]
    }
  }
}
```

<a name="authentication"/>
### Authentication
Unlike Web applications, RESTful APIs are usually stateless, which means sessions or cookies should not be used. A common practice is to send a secret access token with each request to authenticate the user. Since an access token can be used to uniquely identify and authenticate a user, **API requests should always be sent via HTTPS to prevent man-in-the-middle (MitM) attacks**.

This app uses **Bearer token**

Need to add **access_token** to **Headers** in each http request:
```
Authorization: Bearer FFFF70it7tzNsHddEiq0BZ0i-OU8S3xV
```

```php
POST /auth/login

Login[username]
Login[password]
```
Success Answer Example:
```json
{
  "success": true,
  "data": {
    "User": {
      "id": 1,
      "name": "ffff",
      "username": "test",
      "health": 100,
      "max_health": 100,
      "damage": 10,
      "agility": 10,
      "level": 50,
      "experience": 100
    },
    "access_token": "FFFF70it7tzNsHddEiq0BZ0i-OU8S3xV" //This token need to add to Headers
  }
}
```
Error Answer Example:
```json
{
  "success": true,
  "data": [
    {
      "username": [
        "Username cannot be blank."
      ]
    }
  ]
}
```


<a name="start_the_game"/>
### Start the game
This api is entry point to the game.
```
GET /game/intro
```
Success Answer Example:
```json
{
  "success": true,
  "data": {
    "intro": "Long text which describe the world",
    "url": "/question/113" //Next_api_you_need_to_follow
  }
}
```

<a name="questions"/>
### Questions

**Question** - is a generic term for denominating a messages which a game would say to you:
* A Message from a character if you have a conversation
* A Message for describing what you see around
* A Message for suggesting you to do an action
* etc

**Question** usualy includes a list of **Answers**. 
You can choose any answer form the list. Every Answer object has URL which you need to use to choose this answer. Look at the example.
More information about **Answers** here [Answers](#answer)

```
GET question/114
```
```json
{
  "success": true,
  "data": {
    "question": {
      "id": 114,
      "message": " I'm not interested in who you are. You've just arrived. I look after the new arrivals. That's all for new. If you plan to stay alive for a while, you should talk to me. But of course I won't keep you from choosing your own destruction. Well, what do you think?",
      "author": { //Question_has_Author._So_this_is_the_message_from_the_real_character._In_this_case_his_name_is_Diego.
        "id": 1,
        "name": "Diego",
        "health": 500,
        "damage": 100,
        "agility": 100,
        "plus_experience_for_win": 0
      },
      "answers": [ //Here_is_a_few_answer_objects._You_can_answer_to_Diego
        {
          "id": 15,
          "message": "Okay, what do I need to know about this place?",
          "url": {
            "select": "/question/114/answer/15/selector" //To_choose_this_answer_follow_this_url
          }
        },
        {
          "id": 16,
          "message": "Why did you help me?",
          "url": {
            "select": "/question/114/answer/16/selector"
          }
        },
        {
          "id": 17,
          "message": "I have a letter for the High Magician of the Circle of Fire.",
          "url": {
            "select": "/question/114/answer/17/selector"
          }
        }
      ]
    }
  }
}
```

<a name="answer"/>
### Answers
**Answer** - is a generic term for denominating a messages or actions you can do:
* An Answer to a Question if you have a conversation
* Starting fight
* Get an Object to Inventory
* Eat something, start speaking with someone and any other actions
* What location to investigate first?
* etc

Every **Answer** includes link to the next **Question**.
Also you can link a **Trigger** to the **Answer**. **Trigger** will be executed when you select an answer. 
More about triggers here [Triggers](#triggers)
```
GET /question/114/answer/16/selector
```
```json
{
  "success": true,
  "data": {
    "Answer": {
      "id": 16,
      "message": "Why did you help me?"
    },
    "Trigger": {
      "type": null,
      "message": null,
      "data": null
    },
    "next_url": "/question/118" //Follow_this_URL_to_continue_your_journey
  }
}
```

<a name="triggers"/>
### Triggers

**Triggers** is actions linked to **Answers**. Using **Triggers** you can program any behavior.

Currently exists three **Triggers**:
* Add an object to inventory (type: AddObjectToInventory)
* Start Fight (type: Fight)
* Increase Health (type: Treatment)

```
GET /question/126/answer/24/selector
```
```json
{
  "success": true,
  "data": {
    "Answer": {
      "id": 24,
      "message": "Explore mine"
    },
    "Trigger": { //This_trigger_added_an_object_to_inventory._Currently_sword
      "type": "AddObjectToInventory",
      "message": "Object was added to Inventory",
      "data": {
        "Object": {
          "id": 1,
          "type": "weapon",
          "name": "Rusty one-handed sword",
          "damage": 10
        }
      }
    },
    "next_url": "/question/125" //Follow_this_link_to_continue_the_story
  }
}
```


<a name="fight"/>
### Fight

Playing the Game you can meet unfriendly characters. So you will need to fight with them.
Fight always starts from **Fight Trigger** linked to an **Answer** you selected. 

```json
{
  "success": true,
  "data": {
    "Answer": {
      "id": 26,
      "message": "Attack!"
    },
    "Trigger": {
      "type": "Fight",
      "message": "New fight was initiated",
      "data": {
        "Fight": {
          "user_id": 3,
          "character_id": 2,
          "health": 100,
          "answer_id": 26,
          "id": 2
        }
      }
    },
    "next_url": "/answer/26/fight/1" //This_url_will_not_follow_to_the_question
  }
}
```

As you see **next_url** is not following to the next question when **Answer** has **Trigger Fight**. It means you can't 
continue journey until you win or fail in the battle.

#### Fight process

Every round you will need to select **attack type**.

**Attack types** depend on characters. You would see different attack_types for Dragon and Wolf.
Every attack type has **probability** and **damage**. Higher probability of attack type = Higher probability to hit the target.
But Higher probability usually means lower damage. So you can find your own tactic for each enemy. 

##### **real_damage** and **real_probability**

**real_damage** and **real_probability** depends on Users damage and Users agility correspondly. **A weapon** in Users hands also affects real_damage

```
GET /answer/26/fight/1
```
```json
{
  "success": true,
  "data": {
    "Character": {
      "id": 2,
      "name": "Young wolf",
      "health": 0,
      "damage": 5,
      "agility": 10,
      "plus_experience_for_win": 100
    },
    "User": {
      "id": 3,
      "name": "test1",
      "username": "test1",
      "health": 100,
      "max_health": 100,
      "damage": 10,
      "agility": 10,
      "level": 1,
      "experience": 0
    },
    "Attack_types": [
      {
        "id": 1,
        "name": "Hit the paw",
        "damage": 20,
        "real_damage": 30,
        "probability": 20,
        "real_probability": 21,
        "url": "/answer/26/fight/1/attack/1"
      },
      {
        "id": 2,
        "name": "Hit the head",
        "damage": 50,
        "real_damage": 60,
        "probability": 15,
        "real_probability": 16,
        "url": "/answer/26/fight/1/attack/2"
      },
    ]
  }
}
```

After your attack your Enemy will attack you. Every character has his own list of attacks. Every Enemy attack has own damage and own probability.
The more dangerous attacks usually more rare.

```
GET /answer/26/fight/1/attack/1
```

Fight will continue until somebody win.

#### Fight result

It depends on who was a winner. 
If Player won you will get next question.
If Enemy won you will get a possibility to repeat you fight.

After fight you also get experience and level up if you have enough Experience.

<a name="inventory"/>
### Inventory

User has Inventory. Inventory has all object user has ever found. 

```
GET /inventory
```

```json
{
  "success": true,
  "data": {
    "Inventory": [
      {
        "id": 1,
        "type": "weapon",
        "name": "Rusty one-handed sword",
        "damage": 10
      },
    ]
  }
}
```

<a name="active_equipment_slots"/>
### Active Equipment Slots

You can move some types of objects from your **Inventory** to **Active Equipment Slots**. It means you can take the sword or wear armor.

Objects in **Active Equipment Slots** affect your characteristics for Fight.

E.x. if you move a sword with damage 10 to a **weapon slot** you will get +10 to your real_damage in a battle. 
__Currently only weapon slot is working properly__

```
GET /active-equipment/<user_id>
```

```json
{
  "success": false,
  "data": {
    "weapon": {
      "id": 1,
      "type": "weapon",
      "name": "Rusty one-handed sword",
      "damage": 10
    },
    "armor": null,
    "rune": null,
    "boots": null,
    "gloves": null,
    "helmet": null
  }
}
```

Add object from Inventory
```
PUT /active-equipment/<user_id>
```
```
ActiveEquipment[weapon_object_id]
```

<a name="load_game"/>
### Load previous game
When you playing and following the questions actually interior pointer moves from one question to another. 

So the pointer will always point to your current question. Just go to **Start Game** Api and get the current link.

```
GET /game/intro
```

<a name="installation"/>
### Installation
Requirenments: PHP7, Mysql, Any webserver (Nginx, Apache etc)

* Clone repo to your server. 
* Load dump.sql to database

<a name="own_quest"/>
### How to make own quests. Typical scenarios
#### I want to make new creature for fightning. How can I do it?
* Add new creature to table **character**
```sql
INSERT INTO `character`
(`id`, `name`, `health`, `damage`, `agility`,`plus_experience_for_win`)
VALUES (...);
```
* Add attack types for new creature to enemy_attack_type (creature`s hits) and user_attack_type (user`s hits)
```sql
INSERT INTO `enemy_attack_type`
(`id`, `name`,`character_id`,`class`, `probability`, `damage`, `message`)
VALUES(...);

INSERT INTO `gothic`.`user_attack_type`
(`id`,`name`,`class`,`probability`,`damage`,`character_id`,`message`)
VALUES(...);
```
* Add trigger fight for this creature
```sql
INSERT INTO `gothic`.`trigger_fight`
(`character_id`)
VALUES();
```
* Link this trigger to an Answer (when you want to suggest battle to user?)
```sql
UPDATE `gothic`.`answer`
SET
`trigger_type` = 'Fight',
`trigger_id` = <{trigger_id: }>
WHERE `id` = <{expr}>;
```
* Done!

#### I want to add a fairy who ask some questions. If user give correct answer she increase experience. How can I do it?
* Make the dialog with fairy using standard questions and answers flow.
* Make new trigger type: "IncreaseExpirience"
* Create table for new trigger 
```sql
CREATE TABLE `trigger_increase_expirience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expirience_amount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
```
* Insert how many expirience your fairy will give.
 
* Make new class for trigger extended from AbstractTrigger
```php
namespace app\models\answer_trigger;

class TriggerIncreaseExpirience extends AbstractTrigger
{ ... }
```
* Register this class. Add const to ITriger and add it to Factory class
```php
interface ITrigger {
  const TRIGGER_TYPE_INCREASE_EXPIRIENCE = 'increase_expirience';
  }
class Factory
{
  private static $trigger_classes = [
        ITrigger::TRIGGER_TYPE_INCREASE_EXPIRIENCE => TriggerIncreaseExpirience::class,
```
* write logic in 
```php
 public function process (User $User, Answer $Answer)
    {}
```
* Done
