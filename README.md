# SimpleSolution.MailerLiteFinisher
This is a [Neos](https://www.neos.io) plugin which provides a form finisher to add a subscriber to the [MailerLite](https://www.mailerlite.com)) newsletter software.

## Requirements

 * php >= 7
 
## How to Use

Just use the form finisher the same as the Neos form finishers:
 
 ```yml
finishers:
  -
    identifier: 'SimpleSolution.MailerLiteFinisher:MailerLiteFinisher'
    options:
      APIKey: 'YOUR API KEY'
      groupID: 'YOUR GROUP ID'
      variables.email: '{email}'
      variables.firstname: '{firstname}'
      variables.lastname: '{lastname}'
```

### Variables

You can send all variables, which have a field in MailerLite, to the API:
* variables.email (required)
* variables.firstname
* variables.lastname
* variables.company
* variables.country
* variables.city
* variables.phone
* variables.state
* variables.zip