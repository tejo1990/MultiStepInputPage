public class BoothStateService
{
    public string? BoothNumber { get; private set; }
    public string CompanyName { get; private set; } = "";
    public string? Step3Data { get; set; }
    public string? Step4Data { get; set; }
    public string? Step5Data { get; set; }

    public void SetBoothNumber(string? number)
    {
        BoothNumber = number;
    }
    public void SetCompanyName(string companyName)
    {
        CompanyName = companyName;
    }
    public void Reset()
    {
        BoothNumber = null;
        CompanyName = "";
        Step3Data = null;
        Step4Data = null;
        Step5Data = null;
    }
}