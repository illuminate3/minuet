minuet is a [Symfony 6][1] Bootstap / Boiler Plate / Starter Project.

## Descritpion

Minuet is similar to EasyAdmin but not at the same time.

Minuet is intended to be a starting point for your application by giving you:
- An Admin! hey that's unique.
- Translations out of the box. Currently only English but the code should be 99% covered outside of some exception handling.
- Typical user experience with logins, email verification, and passwords.
- A user front end dashboard. This is different! Intended for more of store setup.
- Basic admin based menus.
- A very basic CMS. I'm not trying to win any awards here!
- Twig and CSS is hopefully a somewhat sane system. Maybe I went overboard with the _partials! lol

I didn't like EasyAdmin because I haven't really ever been a fan of running functionality out of the vendor directory unless it's a library.
If you like doing that, don't mind me. I wanted a simple enough base starter app that I can start dropping Controllers on with some twig
and get to work. I don't want to be extending some vendor package. So, now you know why.

So, with Minuet, you get what EasyAdmin offers (I haven't compared and didn't try to feature compete) but in an app format
that you can you use where ever. I did start with code from [ResidenceCMS][5] and riped out what didn't make sense for an
a base application, tweaked the twig and CSS to my liking (nothing wrong with the stuff from Coderberg) abd then started making changes
to fit what I have been wanting in the[Symfony][1] world. Another shoot out should go to [Laravel Boilerplate][6] by rappasoft.
Who sort of inspired me to do Minuet.

## Requirements

- PHP 8.1;
- MySQL >= 5.7;
- And the [usual Symfony application requirements][2].

## Installation

1. Copy ```.env``` to make ```.env.local```
2. Edit database credentials

    ```
    DATABASE_URL="mysql://USER:PASSWORD@127.0.0.1:3306/minuet?serverVersion=5.7"
    ```
    Probably change: ```USER:PASSWORD``` to ```root:root``` don't worry!
    It was just a really good guess!
    Don't forget to change ```minuet``` !

3. Install

    a. do the composer stuff
    ```
    composer install
    ```

    b. then node
    ```
     yarn install
    ```
    ```
     yarn dev-server
    ```

    c. fire up the actual app
    ```
    php bin/console app:install
    ```
    No, I didn't use the ```$``` to show it's a terminal command.
    It's a pain to delete that dang dollar sign.


4. Log in

    minuet.test/admin
    ```
    login: admin@admin.com
    password: admin
    ```
    minuet.test
    ```
    login: user@user.com
    password: user
    ```

## License
MIT ... but most of you don't care anyways. Just don't sell it on code canyon or somewhere like that.
That's just not cool! But hey, got a paying customer? Go for it! Enjoy the free stuff!

## ASK

I don't want money. Well, I do but I'm not going to ask for some coffee from a hugely famous coffee shop.
IF you really do want to through some money pocket change, would you mind doing an animal shelter or other worthy service?

I do want to ask you for your thoughts, ideas, and help though.
- Fixed a bug?
- Have an idea?
- Can do a translation?
- Can do a Vue conversion?
Please try to give back.

## Additional Shout Outs
- This code base was based on [ResidenceCMS][5] by Coderberg. I have made lost of changes but Minuet really does
owe Coderberg a Thank you!
- [Laravel Boilerplate][6] by rappasoft - no code ideas taken but the concept has motivated me!

[1]: https://symfony.com/
[2]: https://symfony.com/doc/current/setup.html#technical-requirements
[5]: https://github.com/Coderberg/ResidenceCMS
[6]: https://github.com/rappasoft/laravel-boilerplate
