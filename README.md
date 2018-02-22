MultiStepBundle
===============

The MultiStepBundle provides a simple interface to build multi step flows,
like dialogs with several pages users have to navigate through.

Naming convention: A "flow" is collection of steps in a specific order.

Each step can be configured how it is represented in URL ("slug")
and what controller action should be called.


Usage
-----

### Routing

If you have just one flow, your routing.yml could look like:

    my_fancy_multistep:
      prefix: /this/is/my/prefix/step/
      resource: "@MultiStepBundle/Resources/config/routing.yml"
      defaults:
        flow_slug: "my_flow"

Then the steps of the flow configured with slug "my_flow" will be available under
```https://YOURHOST/this/is/my/prefix/step/{step_slug}``` .


If you have multiple flows, your routing.yml could look like:

    my_fancy_multistep:
      prefix: /this/is/my/prefix/{flow_slug}/step/
      resource: "@MultiStepBundle/Resources/config/routing.yml"

Then the steps of a flow will then be available under
```https://YOURHOST/this/is/my/prefix/{flow_slug}/step/{step_slug}``` .

For example a flow with slug "second-flow" with step "first-step" will be available under
```https://YOURHOST/this/is/my/prefix/second-flow/step/first-step``` .


### Controllers

You have to configure which controller::action will be called in which step.
It is strongly recommended to extend the ```DefaultStepController``` and use what it provides.


### Example for custom controller

Must probably you want to configure an own controller to be used.
For example if you want to have a form at a specific step, just render it into a custom template.
Important: If you build your form manually, use ```{{ app.request.uri }}``` as the form's action.
Then your own controller is called again with the filled form.
In your controller's action method you can validate and evaluate your form.
If something went wrong, just render your template again with error messages.
If everything is fine, you can call ```$this->redirectToNextStep()``` (assuming that you extend the DefaultStepController).
This will do a HTTP redirect (by default with status code 302) to the next step of the flow.


### Skipping a step

If you want to, you can check some data in your controller's action method before rendering a template.
Then it is possible to immediately call ```$this->redirectToNextStep()``` to skip the step.
You can even do a ```$this->redirectToPreviousStep()``` to throw the user back,
but please be aware to **not** build circular (and thus endless) redirections.


### Remembering data between steps

A multistep flow often relies on data entered previously.
Using symfony you can simply inject the service ```"@session"``` into your controller
(or get it via ```$this->get('session')```).
Then you can write and read session data from and to the user's PHP session using the
```\Symfony\Component\HttpFoundation\Session\SessionInterface```.



Example Configuration
---------------------

    multi_step:
      flows:
        first_test_flow:
          slug: "test-flow-1"     # the slug is the string used in URLs, so it should be a valid URL part
          steps:
            enter_matrix:
              slug: "welcome"
              controller: Fully\Qualified\Class\Name::methodAction
            leave_matrix:
              slug: "byebye"
              # default controller will be used here (not very useful)
        second_flow:
          slug: "test-2-flow"
          steps:
            enter_matrix: # step ids and slugs must be unique (only inside flows)
              slug: "welcome"
              template: 'MultiStepBundle::default_step.html.twig'
              # default controller will be used here, but a user specific template
            leave_matrix:
              slug: "byebye"
              controller: another\Fully\Qualified\Class\Name::anotherMethodAction

The ```controller``` is parsed by symfony's ```ControllerResolver```,
so theoretically you should be able to use every syntax symfony is able to understand.

The action is called with parameters determined by an ```ArgumentResolver```,
such that it should behave like everywhere else in your symfony project.
E.g. you can inject for example the ```Request $request``` parameter into the called method.


License
-------

MIT
