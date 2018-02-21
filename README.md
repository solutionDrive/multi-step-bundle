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
If you want to, you can extend the ```DefaultStepController``` and use what it provides.


Example Configuration
---------------------

    multi_step:
        flows:
            first_test_flow:
                slug: "test-flow-1"
                steps:
                    enter_matrix:
                        slug: "welcome"
                        controller: Fully\Qualified\Class\Name::methodAction
                    leave_matrix:
                        slug: "byebye"
                        # default controller will be used here (not useful!)
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


License
-------

MIT
