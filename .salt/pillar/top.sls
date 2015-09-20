base:
  '*':
    - general
  'os_family:Debian':
    - match: grain
    - debian
  'os_family:RedHat':
    - match: grain
    - redhat