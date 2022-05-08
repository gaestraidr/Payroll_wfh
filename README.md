# Rekamedis_Solus
 Web-Based Payroll with Absensi Check-In for WFO & WFH, with Izin feature and track Absensi-Gap by each Pegawai.

 This application is solely a personal project that involve standard operational procedure within checkin protocol commonly found in any company. Built with PHP using Laravel Framework. Designed with Blade.

## Current Feature

- With 2 Dashboard for normal Manager / Admin & Pegawai.

### Pegawai Dashboard
- Automatically track absensi history of pegawai each month by calculating performance based on hour, timing, and gap between daily submitted absent.
- Automatically track overtime to optimize wage payment based on days-off absen submitted.
- Notification on availability of absensi, izin approval, and gaji changes.
- Statistic of pegawai track record with izin, absensi, and gaji.
- Submit izin request with image for provability purpose of the izin, time frame of izin from start to end, and input box to write the importance reasoning for submitting.
- History Absensi page designed with month date picker to choose, and organized absen masuk & pulang into days for readability.
- Convert to document / print them for archiving purpose within absensi & gaji.

### Manager / Admin Dashboard
- All feature within Pegawai Dashboard
- Notification on Problematic Pegawai that has passed absensi gap based on set threshold.
- Giving approval for submitted Izin.
- See Other Pegawai track record for izin, absensi, and gaji changes.
- Add, remove, or edit Pegawai Data.
- Add, remove, or edit Jabatan Data.
- Convert to document / print them for archiving purpose within absensi, izin, and gaji.
