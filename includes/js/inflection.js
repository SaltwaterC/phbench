/*
Copyright (c) 2007 Ryan Schuft (ryan.schuft@gmail.com)

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

/*
  This code is based in part on the work done in Ruby to support
  infection as part of Ruby on Rails in the ActiveSupport's Inflector
  and Inflections classes.  It was initally ported to Javascript by
  Ryan Schuft (ryan.schuft@gmail.com).

  The code is available at http://code.google.com/p/inflection-js/

  The basic usage is:
    1. Include this script on your web page.
    2. Call functions on any String object in Javascript

  Currently implemented functions:

    String.pluralize(plural) == String
      renders a singular English language noun into its plural form
      normal results can be overridden by passing in an alternative

    String.singularize(singular) == String
      renders a plural English language noun into its singular form
      normal results can be overridden by passing in an alterative
*/

/*
  This function adds plurilization support to every String object
    Signature:
      String.pluralize(plural) == String
    Arguments:
      plural - String (optional) - overrides normal output with said String
    Returns:
      String - singular English language nouns are returned in plural form
    Examples:
      "person".pluralize() == "people"
      "octopus".pluralize() == "octopi"
      "Hat".pluralize() == "Hats"
      "person".pluralize("guys") == "guys"
*/
if(!String.prototype.pluralize)String.prototype.pluralize=function(plural)
{
  var str=this;
  if(plural)str=plural;
  else
  {
    var uncountable=false;
    for(var x=0;!uncountable&&x<this._uncountable_words.length;x++)
      uncountable=(this._uncountable_words[x]==str.toLowerCase());
    if(!uncountable) 
    {
      var matched=false;
      for(var x=0;!matched&&x<=this._plural_rules.length;x++)
      {
        matched=str.match(this._plural_rules[x][0]);
        if(matched)
          str=str.replace(this._plural_rules[x][0],this._plural_rules[x][1]);
      }
    }
  }
  return str;
};

/*
  This function adds singularization support to every String object
    Signature:
      String.singularize(singular) == String
    Arguments:
      singular - String (optional) - overrides normal output with said String
    Returns:
      String - plural English language nouns are returned in singular form
    Examples:
      "people".singularize() == "person"
      "octopi".singularize() == "octopus"
      "Hats".singularize() == "Hat"
      "guys".singularize("person") == "person"
*/
if(!String.prototype.singularize)
  String.prototype.singularize=function(singular)
  {
    var str=this;
    if(singular)str=singular;
    else
    {
      var uncountable=false;
      for(var x=0;!uncountable&&x<this._uncountable_words.length;x++)
        uncountable=(this._uncountable_words[x]==str.toLowerCase());
      if(!uncountable)
      {
        var matched=false;
        for(var x=0;!matched&&x<=this._singular_rules.length;x++)
        {
          matched=str.match(this._singular_rules[x][0]);
          if(matched)
            str=str.replace(this._singular_rules[x][0],
              this._singular_rules[x][1]);
        }
      }
    }
    return str;
  };

/*
  This is a list of nouns that use the same form for both singular and plural.
  This list should remain entirely in lower case to correctly match Strings.
  You can override this list for all Strings or just one depending on if you
  set the new values on prototype or on a given String instance.
*/
if(!String.prototype._uncountable_words)String.prototype._uncountable_words=[
  'equipment','information','rice','money','species','series','fish','sheep',
  'moose','deer','news'
];

/*
  These rules translate from the singular form of a noun to its plural form.
  You can override this list for all Strings or just one depending on if you
  set the new values on prototype or on a given String instance.
*/
if(!String.prototype._plural_rules)String.prototype._plural_rules=[
  [new RegExp('(m)an$','gi'),'$1en'],
  [new RegExp('(pe)rson$','gi'),'$1ople'],
  [new RegExp('(child)$','gi'),'$1ren'],
  [new RegExp('(ax|test)is$','gi'),'$1es'],
  [new RegExp('(octop|vir)us$','gi'),'$1i'],
  [new RegExp('(alias|status)$','gi'),'$1es'],
  [new RegExp('(bu)s$','gi'),'$1ses'],
  [new RegExp('(buffal|tomat)o$','gi'),'$1oes'],
  [new RegExp('([ti])um$','gi'),'$1a'],
  [new RegExp('sis$','gi'),'ses'],
  [new RegExp('(?:([^f])fe|([lr])f)$','gi'),'$1$2ves'],
  [new RegExp('(hive)$','gi'),'$1s'],
  [new RegExp('([^aeiouy]|qu)y$','gi'),'$1ies'],
  [new RegExp('(x|ch|ss|sh)$','gi'),'$1es'],
  [new RegExp('(matr|vert|ind)ix|ex$','gi'),'$1ices'],
  [new RegExp('([m|l])ouse$','gi'),'$1ice'],
  [new RegExp('^(ox)$','gi'),'$1en'],
  [new RegExp('(quiz)$','gi'),'$1zes'],
  [new RegExp('s$','gi'),'s'],
  [new RegExp('$','gi'),'s']
];

/*
  These rules translate from the plural form of a noun to its singular form.
  You can override this list for all Strings or just one depending on if you
  set the new values on prototype or on a given String instance.
*/
if(!String.prototype._singular_rules)String.prototype._singular_rules=[
  [new RegExp('(m)en$','gi'),'$1an'],
  [new RegExp('(pe)ople$','gi'),'$1rson'],
  [new RegExp('(child)ren$','gi'),'$1'],
  [new RegExp('([ti])a$','gi'), '$1um'],
  [new RegExp('((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$',
    'gi'),'$1$2sis'],
  [new RegExp('(hive)s$','gi'), '$1'],
  [new RegExp('(tive)s$','gi'), '$1'],
  [new RegExp('([lr])ves$','gi'), '$1f'],
  [new RegExp('([^fo])ves$','gi'), '$1fe'],
  [new RegExp('([^aeiouy]|qu)ies$','gi'), '$1y'],
  [new RegExp('(s)eries$','gi'), '$1eries'],
  [new RegExp('(m)ovies$','gi'), '$1ovie'],
  [new RegExp('(x|ch|ss|sh)es$','gi'), '$1'],
  [new RegExp('([m|l])ice$','gi'), '$1ouse'],
  [new RegExp('(bus)es$','gi'), '$1'],
  [new RegExp('(o)es$','gi'), '$1'],
  [new RegExp('(shoe)s$','gi'), '$1'],
  [new RegExp('(cris|ax|test)es$','gi'), '$1is'],
  [new RegExp('(octop|vir)i$','gi'), '$1us'],
  [new RegExp('(alias|status)es$','gi'), '$1'],
  [new RegExp('^(ox)en','gi'), '$1'],
  [new RegExp('(vert|ind)ices$','gi'), '$1ex'],
  [new RegExp('(matr)ices$','gi'), '$1ix'],
  [new RegExp('(quiz)zes$','gi'), '$1'],
  [new RegExp('s$','gi'), '']
];
