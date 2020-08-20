import { environment } from '../../environments/environment';
export class Constants {
    public static get API_URL(): string { return environment.api ? environment.api : 'http://localhost/jal.projects.api/public/index.php/'; }
}
